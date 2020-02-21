<?php

namespace JournaleBundle\Controller;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\GaugeChart;
use JournaleBundle\Entity\Trophy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JournaleBundle\Entity\Journale;
use JournaleBundle\Form\JournaleType;
use JournaleBundle\Form\RechercheType;



class DefaultController extends Controller
{
    public function createAction(Request $request)
    {   //create an object to store our data after the form submission
        $journale=new Journale();
        //prepare the form with the function: createForm()
        $form=$this->createForm(JournaleType::class,$journale);
        //extract the form answer from the received request
        $em = $this->getDoctrine()->getEntityManager();


        $EventsTest = $em->getRepository('JournaleBundle:Journale')->findBy(array(
            'user' => $this->getUser()->getId(),
        ));
        $form=$form->handleRequest($request);
        //if this form is valid
        if(  $form->isValid()) {
            //create an entity manager object
            $journale->setIdchasseur($this->getUser()->getId());
            $em = $this->getDoctrine()->getManager();
            //persist the object $club in the ORM
            $file =  $journale->getImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $pathfile=$this->container->getParameter('pathmedia');
            $file->move(

                $pathfile,
                $fileName
            );


            $journale->setImage($fileName);



            $em->persist($journale);

            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('read');


        }
        else{
            return $this->render('@Journale/Default/create.html.twig', array(
                'form'=>$form->createView() ));
        }


    }
    public function readAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id = $user->getId();

        $journales = $this->getDoctrine()->getRepository(Journale::class)->Finddql($id);

        return $this->render("@Journale/Default/read.html.twig", array('journales' => $journales));
    }
    public function readALLAction()
    {


        $journales = $this->getDoctrine()->getRepository(Journale::class)->findAll();

        return $this->render("@Journale/Default/readAll.html.twig", array('journales' => $journales));
    }
    public function MAJAction(Request $request, $id)
    {
        $journales= $this->getDoctrine()->getRepository(Journale::class)
            ->find($id);

        $form= $this->createForm(JournaleType::class,$journales);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $file =  $journales->getImage();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $pathfile=$this->container->getParameter('pathmedia');
            $file->move(

                $pathfile,
                $fileName
            );


            $journales->setImage($fileName);



            $em->persist($journales);

            $em->flush();


            return $this->redirectToRoute("read");
        }
        return $this->render("@Journale/Default/create.html.twig",
            array("form"=>$form->createView()));
    }
    public function deleteAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $journale= $em->getRepository(Journale::class)->find($id);
        //remove from the ORM
        $em->remove($journale);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("read");
    }
    public function deleteAllAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $journale= $em->getRepository(Journale::class)->find($id);
        //remove from the ORM
        $em->remove($journale);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("readAll");
    }
    public function detailsAction(Request $request, $id)
    {
        $journales = $this->getDoctrine()->getRepository(journale::class)
            ->findBy(array('journale'=>$id) );


        return $this->render("@Journale/Default/details.html.twig", array('journales' => $journales));
    }
    public function listeAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id = $user->getId();

        $trophies = $this->getDoctrine()->getRepository(Trophy::class)->Finddql($id);

        return $this->render("@Journale/Default/liste.html.twig", array('trophies' => $trophies));
    }
    public function rechercheAction(Request $request)
    {
        $journale = new Journale();
        $form = $this->createForm(RechercheType::class, $journale);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $journales = $this->getDoctrine()->getRepository(Journale::class)
                ->findBy(array('lieu' => $journale->getLieu()));}

        else{
            $journales = $this->getDoctrine()->getRepository(Journale::class)
                ->findAll();
        }
        return $this->render("@Journale/Default/recherche.html.twig", array("form" => $form->createView(), 'journales'=>$journales));

    }
    public function statAction(){
        $pieChart = new LineChart();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id = $user->getId();

        $journales=$this->getDoctrine()->getRepository(Journale::class)->finddql($id);
       // $pieChart->getData()->setArrayToDataTable(

           // $aa="[['Task', 'Hours per Day']";
        $aa=array();
        array_push($aa,['Task', 'Nombre de chasse par Date']);
       // array_push($aa,   ['Work',     11]);


        foreach ($journales as $journale ){
            array_push($aa,   [$journale->getDate()->format('M-d'),     $journale->getNbchasse()]);


                }
//$aa.="]";
       // );
//var_dump($aa);
//exit();
        $pieChart->getData()->setArrayToDataTable(

           $aa
                // }

        );

        $pieChart->getOptions()->setTitle('Ma journal Par Date de chasse');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(700);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#8489C3');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Libre Franklin');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $pieChart->getOptions()->setBackgroundColor('#CCE7E6');





        return $this->render('@Journale/charts/charts.html.twig', array('piechart' => $pieChart));
    }
    public function listeuserAction()
    {
        $users = $this->getDoctrine()->getRepository(Journale::class)->nbuser();
        $pieChart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart();
        $pieChart->getData()->setArrayToDataTable([
            ['Année', 'Nombre Users'],
            ['2019', 0],
            ['2020', $users]

        ]);

        $pieChart->getOptions()->getChart()
            ->setTitle('Statistiques')
            ->setSubtitle('Users, Nombre de Utilisateur actifs pour 2019-2020');
        $pieChart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(600)
            ->setColors(['#1b9e77'])
            ->getVAxis()
            ->setFormat('decimal')->setTitle('Nombre de comptes')
            ->setBaselineColor('#1b9e77');
        return $this->render('@Journale/charts/chartsAdmin.html.twig', array('piechart' => $pieChart));
}
    public function listenbchasseAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $id = $user->getId();
        $chasses = $this->getDoctrine()->getRepository(Journale::class)->nbchasse($id);
        $pieChart1 = new GaugeChart();
        $pieChart1->getData()->setArrayToDataTable([
            ['Label', 'Value'],
            ['Chasse', (int)$chasses],

        ]);
        $pieChart1->getOptions()->setWidth(300);
        $pieChart1->getOptions()->setHeight(400);
        $pieChart1->getOptions()->setRedFrom(90);
        $pieChart1->getOptions()->setRedTo(100);
        $pieChart1->getOptions()->setYellowFrom(75);
        $pieChart1->getOptions()->setYellowTo(90);
        $pieChart1->getOptions()->setGreenFrom(0);
        $pieChart1->getOptions()->setGreenTo(75);
        $pieChart1->getOptions()->setMinorTicks(5);

        return $this->render('@Journale/charts/chartsChasse.html.twig', array('piechart1' => $pieChart1));
    }
}

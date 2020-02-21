<?php

namespace JournaleBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class JournaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('animal', ChoiceType::class, array( 'choices' => array( 'Grand Gibier' => 'Grand Gibier','Petit Gibier de Plaine' =>'Petit Gibier de Plaine',
            'Oiseau de Passage' => 'Oiseau de Passage','Corvidés' => 'Corvidés')))
            ->add('nbchasse',	NumberType::class,array('attr' => array('placeholder' =>
             'Saisir nombre de chasse',)))
            ->add('lieu', ChoiceType::class, array( 'choices' => array( ' Bizerte' => ' Bizerte','Oued Zarga' =>'Oued Zarga',
                'Maagoula.' => 'Maagoula.','Dekhva' => 'Dekhva','Eloudrenne' => 'Eloudrenne',
                'Soliman' => 'Soliman','Le Krib' => 'Le Krib','Dahmani' => 'Dahmani',)))

            ->add('date',DateType::class,array(

                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'calendar'
                )))->add('description', TextareaType::class)
            ->add('image',FileType::class,array('attr'=>array( 'class'=>'form-control col-md-6','style'=>'margin-bottom:15px;')
                ))

            ->add('save',submitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JournaleBundle\Entity\Journale'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'journalebundle_journale';
    }


}

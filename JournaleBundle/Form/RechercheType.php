<?php

namespace JournaleBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lieu',
            ChoiceType::class, array( 'choices' => array( ' Bizerte' => ' Bizerte','Oued Zarga' =>'Oued Zarga',
        'Maagoula.' => 'Maagoula.','Dekhva' => 'Dekhva','Eloudrenne' => 'Eloudrenne',
        'Soliman' => 'Soliman','Le Krib' => 'Le Krib','Dahmani' => 'Dahmani',)))
            ->add ('chercher',SubmitType::class);

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
        return 'Journalebundle_Journale';
    }


}

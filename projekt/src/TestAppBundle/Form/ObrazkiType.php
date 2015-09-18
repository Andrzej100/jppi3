<?php

namespace TestAppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObrazkiType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
            ->add('nazwa',null,array('attr' => array('style' => 'width: 245px')))
            ->add('data', 'file'  , array('attr' => array('id'=>'file','class'=>'btn btn-default'))
               
         
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TestAppBundle\Entity\Obrazki'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'obrazki';
    }
}

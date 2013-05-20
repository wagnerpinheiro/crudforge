<?php

namespace Crudforge\CrudforgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', 'choice', array('choices' => array('string' => 'Texto', 'integer' => 'Inteiro', 'date' => 'Data', 'decimal' => 'Decimal')))
            ->add('length')
            ->add('scale')
            ->add('document')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crudforge\CrudforgeBundle\Entity\Fields'
        ));
    }

    public function getName()
    {
        return 'crudforge_crudforgebundle_fieldstype';
    }
}

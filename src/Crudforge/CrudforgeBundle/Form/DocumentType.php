<?php

namespace Crudforge\CrudforgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('name')
            //->add('user')            
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crudforge\CrudforgeBundle\Entity\Document'
        ));
    }

    public function getName()
    {
        return 'crudforge_crudforgebundle_documenttype';
    }
}

<?php

namespace Crudforge\CrudforgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SharesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label'     => 'e-mail'
            ))
            ->add('view_perm', 'checkbox', array(
                'label'     => 'visualizar',
                'required'  => false,
            ))
            ->add('edit_perm', 'checkbox', array(
                'label'     => 'editar',
                'required'  => false,
            ))
            ->add('create_perm', 'checkbox', array(
                'label'     => 'cadastrar',
                'required'  => false,
            ))
            ->add('delete_perm', 'checkbox', array(
                'label'     => 'deletar',
                'required'  => false,
            ))
            ->add('user')
            ->add('document')
            ->add('user_shared')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crudforge\CrudforgeBundle\Entity\Shares'
        ));
    }

    public function getName()
    {
        return 'crudforge_crudforgebundle_sharestype';
    }
}

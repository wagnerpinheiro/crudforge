<?php

namespace Crudforge\CrudforgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SharesType extends AbstractType
{
    private $document;
    
    public function __construct(\Crudforge\CrudforgeBundle\Entity\Document $document = null)
    {
        $this->document = $document;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label'     => 'e-mail'
            ))
            ->add('view_perm', 'checkbox', array(
                'label'     => 'permitir visualizar',
                'required'  => false,                
            ))
            ->add('edit_perm', 'checkbox', array(
                'label'     => 'permitir editar',
                'required'  => false,
            ))
            ->add('create_perm', 'checkbox', array(
                'label'     => 'permitir cadastrar',
                'required'  => false,
            ))
            ->add('delete_perm', 'checkbox', array(
                'label'     => 'permitir deletar',
                'required'  => false,
            ))
            //->add('user')
            ->add('document', 'entity_hidden', array(
               'class' => 'CrudforgeBundle:Document'
            ))
            //->add('user_shared')
        ;
        
        $factory = $builder->getFormFactory();
        $document = $this->document;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use($document, $factory){
                if($document){
                    $data = $event->getData();
                    $data->setDocument($document);
                    $event->setData($data);
                }
            }
        );
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

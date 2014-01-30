<?php

namespace Crudforge\CrudforgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FieldsType extends AbstractType
{
    private $document;
    
    public function __construct(\Crudforge\CrudforgeBundle\Entity\Document $document = null)
    {
        $this->document = $document;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'nome do campo'
            ))
            ->add('type', 'choice', array(
                'choices' => array('string' => 'Texto', 'integer' => 'Inteiro', 'date' => 'Data', 'decimal' => 'Decimal'),
                'label' => 'tipo',
            ))
            ->add('length', 'integer', array(
                'label'=>'tamanho',
                'required' => false
            ))
            ->add('scale', 'integer', array(
                'label'=>'decimais',
                'required' => false                
            ))
            ->add('nullable', 'checkbox', array(
                'label'=>'opcional',
                'required' => false                
            ))
            ->add('document', 'entity_hidden', array(
               'class' => 'CrudforgeBundle:Document'
            ))
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
            'data_class' => 'Crudforge\CrudforgeBundle\Entity\Fields'
        ));
    }

    public function getName()
    {
        return 'crudforge_crudforgebundle_fieldstype';
    }
}

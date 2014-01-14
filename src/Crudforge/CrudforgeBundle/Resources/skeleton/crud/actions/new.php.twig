
    /**
     * Displays a form to create a new {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/new", name="{{ route_name_prefix }}_new")
     * @Template()
{% endif %}
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('crudforge.security')->getAclManager()
            ->checkGrantedClass('CREATE', $em->getRepository('{{ bundle }}:{{ entity }}')->getClassName());
    
        $entity = new {{ entity_class }}();
        $form   = $this->createForm(new {{ entity_class }}Type(), $entity);
        
        $document = $this->get('crudforge.core')->getDocumentByEntity('{{entity}}');

{% if 'annotation' == format %}
        return array(
            'entity' => $entity,
            'document' => $document,
            'form'   => $form->createView(),
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:new.html.twig', array(
            'entity' => $entity,
            'document' => $document,
            'form'   => $form->createView(),
        ));
{% endif %}
    }

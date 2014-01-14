
    /**
     * Lists all {{ entity }} entities.
     *
{% if 'annotation' == format %}
     * @Route("/", name="{{ route_name_prefix }}")
     * @Template()
{% endif %}
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $this->get('crudforge.security')->getAclManager()
            ->checkGrantedClass('VIEW', $em->getRepository('{{ bundle }}:{{ entity }}')->getClassName());
        
        $entities = $em->getRepository('{{ bundle }}:{{ entity }}')->findAll();
        
        $document = $this->get('crudforge.core')->getDocumentByEntity('{{entity}}');

{% if 'annotation' == format %}
        return array(
            'entities' => $entities,
            'document' => $document,
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:index.html.twig', array(
            'entities' => $entities,            
            'document' => $document,
        ));
{% endif %}
    }

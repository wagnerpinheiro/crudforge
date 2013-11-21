
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
        
        $aclManager = $this->get('crudforge.security')->getAclManager();
        if(!$aclManager->isGrantedClass('VIEW', $em->getRepository('{{ bundle }}:{{ entity }}')->getClassName())){
            throw $this->createNotFoundException('Without Permission.');
        }

        $entities = $em->getRepository('{{ bundle }}:{{ entity }}')->findAll();

{% if 'annotation' == format %}
        return array(
            'entities' => $entities,
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:index.html.twig', array(
            'entities' => $entities,
        ));
{% endif %}
    }


    /**
     * Finds and displays a {{ entity }} entity.
     *
{% if 'annotation' == format %}
     * @Route("/{id}/show", name="{{ route_name_prefix }}_show")
     * @Template()
{% endif %}
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('{{ bundle }}:{{ entity }}')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find {{ entity }} entity.');
        }
        
        $aclManager = $this->get('crudforge.security')->getAclManager();
        if(!$aclManager->isGranted('VIEW', $entity)){
            throw $this->createNotFoundException('Without Permission.');
        }
{% if 'delete' in actions %}

        $deleteForm = $this->createDeleteForm($id);
{% endif %}

{% if 'annotation' == format %}
        return array(
            'entity'      => $entity,
{% if 'delete' in actions %}
            'delete_form' => $deleteForm->createView(),
{% endif %}
        );
{% else %}
        return $this->render('{{ bundle }}:{{ entity|replace({'\\': '/'}) }}:show.html.twig', array(
            'entity'      => $entity,
{% if 'delete' in actions %}
            'delete_form' => $deleteForm->createView(),
{%- endif %}
        ));
{% endif %}
    }

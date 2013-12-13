<?php

namespace Crudforge\CrudforgeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/home")
     * @Template()
     */
    public function indexAction()
    {
        $security = $this->get('security.context');
        if($security->isGranted('ROLE_ADMIN')){
            $template = 'CrudforgeBundle:Default:indexAdmin.html.twig';
        }elseif($security->isGranted('ROLE_USER')){
            $template = 'CrudforgeBundle:Default:indexUser.html.twig';
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $estatisticas['users_count'] = $em->createQueryBuilder()
              ->select('COUNT(u)')
              ->from('CrudforgeBundle:Users', 'u')
              ->getQuery()
              ->getSingleScalarResult();
        
        $estatisticas['schemas_count'] = $em->createQueryBuilder()
              ->select('COUNT(d)')
              ->from('CrudforgeBundle:Document', 'd')
              ->getQuery()
              ->getSingleScalarResult();
        
        return $this->render(
            $template,
            array('estatisticas'=>$estatisticas)
        );
        
    }
    
    /**
     * @Route("/logout")
     * @Template()
     */
    public function logoutAction() {
        //clear the token, cancel session and redirect
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl('home'));
    }
    
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'CrudforgeBundle:Default:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
}

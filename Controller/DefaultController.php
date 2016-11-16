<?php

namespace RB\MailBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Setting controller.
 *
 * @Route("/inbox")
 */
class DefaultController extends Controller
{

    public function __construct()
    {

    }



    /**
     * @Route("/", name="inbox")
     */
    public function indexAction()
    {
        $mailbox = $this->get('rb.mailbox');
        $mailbox->mailsIDList();

        $idList = $mailbox->mailsIDList();

        $id = end($idList);

        return $this->render('RBMailBoxBundle:Default:index.html.twig',[
            'unseen' => $mailbox->countUnseen(),
            'mailsIDList'  => $idList,
            'mails'  => array_reverse($mailbox->headers()),
            'mail'   => $mailbox->get($id),
            'id'     => $id
            ]
        );
    }



    /**
    * @Route("/show/{id}",name="mail_show")
    */
    public function showAction(Request $request, $id, $type = 'Html')
    {
        $mailbox = $this->get('rb.mailbox');

        return $this->render('RBMailBoxBundle:Items:mail.html.twig',[
            'id'    => $id,
            'mail'  => $mailbox->get($id)
        ]);
    }


    /**
    * @Route("/html/{id}",name="mail_html")
    */
    public function htmlAction(Request $request, $id, $type = 'Html')
    {
        $mailbox = $this->get('rb.mailbox');

        return $this->render('RBMailBoxBundle:Items:mail_textHtml.html.twig',[
            'id'    => $id,
            'mail'  => $mailbox->get($id)
        ]);
    }



    /**
    * @Route("/mail_refresh",name="mail_refresh")
    */
    public function mail_refreshAction(Request $request)
    {
        $mailbox = $this->get('rb.mailbox');
        $mailbox->mailsIDList();

        return $this->render('RBMailBoxBundle:Items:list.html.twig',[
            'mails'  => $mailbox->headers()
        ]);
    }


    /**
    * @Route("/mail_check",name="mail_check")
    */
    public function mail_checkAction(Request $request)
    {
        $type = $request->request->get("type",'ids');

        $mailbox = $this->get('rb.mailbox');
        $r = $mailbox->mailsIDList();

        if($type == 'headers')
            $r = $mailbox->headers();


        return new JsonResponse($r);
    }





    /**
    * @Route("/mail_flag/{id}",name="mail_flag")
    */
    public function mail_flagAction(Request $request, $id)
    {
        $mailbox = $this->get('rb.mailbox');

        $r = [
            'infotype'=>'success',
            'msg'=>'ok'
        ];

        return new JsonResponse($r);
    }



    /**
    * @Route("/mail_print/{id}",name="mail_print")
    */
    public function mail_printAction(Request $request, $id)
    {
        $mailbox = $this->get('rb.mailbox');

    }



    /**
    * @Route("/mail_del/{id}",name="mail_del")
    */
    public function mail_delAction(Request $request, $id)
    {
        $mailbox = $this->get('rb.mailbox');
        $r = [
            'infotype'=>'success',
            'msg'=>'ok'
        ];

        return new JsonResponse($r);
    }



    /**
    * @Route("/mail_new",name="mail_new")
    */
    public function mail_newAction(Request $request)
    {
        return $this->render('RBMailBoxBundle:Items:form.html.twig',[

        ]);
    }


    /**
    * @Route("/mail_reply/{id}",name="mail_reply")
    */
    public function mail_replyAction(Request $request, $id)
    {

        $mailbox = $this->get('rb.mailbox');

        return $this->render('RBMailBoxBundle:Items:form.html.twig',[
            'mail' => $mailbox->get($id)
        ]);
    }



    /**
    * @Route("/mail_send",name="mail_send")
    */
    public function mail_sendAction(Request $request)
    {
        return $this->render('RBMailBoxBundle:Items:form.html.twig',[

        ]);

    }

}

<?php
namespace RB\MailBoxBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class RBMailBoxExtension  extends \Twig_Extension{


    public function __construct($container, $twig, $router)
    {
        $this->container = $container;
        $this->router    = $router;
        $this->twig      = $twig;
    }


    public function getName(){
        return 'rb_mail_extension';
    }


    public function mailsender($mailsender)
    {
        $info = explode('<', $mailsender);
        return $info[0];
    }


    public function maildate($maildate)
    {
        $now = time();
        $dif = $now - $maildate;

        $h24 = 86400;
        $w1 = 604800;

        if($dif < $h24)
            $date = date('H:i', $maildate);
        else if($dif < $w1)
            $date = date('D d m H:i', $maildate);
        else
            $date = date('d M Y H:i', $maildate);

        return $date;
    }




    public function btn_mail($id)
    {
        echo $this->twig->render('RBMailBoxBundle:Twig:mail-menu.html.twig',[
            'id' => $id
        ]);
    }



    public function contact_input($id)
    {
        $list = [];
    	echo $this->twig->render('RBMailBoxBundle:Twig:contact-input.html.twig',[

        ]);
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mailsender', array($this, 'mailsender')),
            new \Twig_SimpleFilter('maildate', array($this, 'maildate')),
        );
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('btn_mail', [$this, 'btn_mail'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('contact_input', [$this, 'contact_input'], ['is_safe' => ['html']])
        );
    }


}

?>
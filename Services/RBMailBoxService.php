<?php
namespace RB\MailBoxBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

use PhpImap\Mailbox as ImapMailbox;

use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;



class RBMailBoxService {



    public function __construct($container)
    {
		$this->container=$container;

		$this->login();
    }



    public function login()
    {
		$dir_users = $this->container->getParameter('dir_users');

        $imap      = $this->container->getParameter('mail.imap');
        $mail      = $this->container->getParameter('mail.mail');
		$pw        = $this->container->getParameter('mail.pw');

		return $this->mailbox   = new ImapMailbox('{'.$imap.'}INBOX', $mail, $pw, $dir_users);
    }


   /**
    * voir les recherches disponibles :
    * http://php.net/manual/en/function.imap-search.php
    */
	public function mailsIDList($search = 'ALL')
    {
		$this->mailsID     = $this->mailbox->searchMailbox($search);

		if(!$this->mailsID)
		    die('Mailbox is empty');

		return $this->mailsID;
    }



    public function headers()
    {
    	return $this->mailsHeader = $this->mailbox->getMailsInfo($this->mailsID);
    }



	public function get($id = 0)
    {
    	$this->mailsIDList('ALL');
		return $this->mail =  $this->mailbox->getMail($this->mailsID[$id]);
    }


    public function countUnseen()
    {
    	$this->mailsIDUnseen = $this->mailbox->searchMailbox('UNSEEN');

    	if(!$this->mailsIDUnseen)
		    $this->mailsIDUnseen = [];

    	return $this->unseen = count($this->mailsIDUnseen);
    }
}

?>
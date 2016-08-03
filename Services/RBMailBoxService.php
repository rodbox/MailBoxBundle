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



    public function headers($search = 'ALL')
    {
        $this->mailsIDList($search);
    	return $this->mailsHeader = $this->mailbox->getMailsInfo($this->mailsID);
    }



	public function get($id = 1)
    {
    	$this->mailsIDList('ALL');
		return $this->mail =  $this->mailbox->getMail($id);
    }



    public function countUnseen()
    {
        $this->count['unseen'] = $this->countMails('UNSEEN');

        /* SERVICE : rb.counter */
        $this->container->get('rb.counter')->setCounter('unseen',$this->count['unseen']);
        /* END SERVICE :  rb.counter */

        return $this->count['unseen'];
    }



    public function countAll()
    {
        return $this->count['all'] = $this->countMails('ALL');
    }



    public function countMails($search = 'ALL')
    {
    	$this->mailsIDUnseen = $this->mailbox->searchMailbox($search);

    	if(!$this->mailsIDUnseen)
		    $this->mailsIDUnseen = [];

    	return count($this->mailsIDUnseen);
        # code...
    }
}

?>
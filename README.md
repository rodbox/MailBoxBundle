# RBMailBoxBundle :

MailBox pour RB en version Alpha

## routing :
```
rb_MailBox:
    resource: "@RBMailBundle/Controller/"
    type:     annotation
    prefix:   /mailbox/
```

## config :
```
    - { resource: "@RBMailBoxBundle/Resources/config/services.yml" }
parameters:
    mail.mail: john.doe@domain.com
    mail.pw: plainpassword
    mail.dir: /
    mail.imap: imapserver.com:993/imap/ssl
```

## AppKernel.php :
```
 public function registerBundles()
    {
        $bundles = [
           ...
            new RB\MailBoxBundle\RBMailBoxBundle(),
```


doc dependance :
[https://packagist.org/packages/php-imap/php-imap](https://packagist.org/packages/php-imap/php-imap)
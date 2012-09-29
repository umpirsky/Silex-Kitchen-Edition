<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Zymfony\Component\Validator\Constraint;
use Symfony\Component\Form\FormError;

$app->match('/', function() use ($app) {
    $app['session']->setFlash('warning', 'Warning flash message');
    $app['session']->setFlash('info', 'Info flash message');
    $app['session']->setFlash('success', 'Success flash message');
    $app['session']->setFlash('error', 'Error flash message');

    return $app['twig']->render('index.html.twig');
})->bind('homepage');

$app->match('/login', function() use ($app) {

    $form = $app['form.factory']->createBuilder('form')
        ->add('email', 'email', array(
            'label'       => 'Email',
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Email(),
            ),
        ))
        ->add('password', 'password', array(
            'label'       => 'Password',
            'constraints' => array(
                new Assert\NotBlank(),
            ),
        ))
        ->getForm()
    ;

    if ('POST' === $app['request']->getMethod()) {
        $form->bindRequest($app['request']);

        if ($form->isValid()) {

            $email    = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            if ('email@example.com' == $email && 'password' == $password) {
                $app['session']->set('user', array(
                    'email' => $email,
                ));

                $app['session']->setFlash('notice', 'You are now connected');

                return $app->redirect($app['url_generator']->generate('homepage'));
            }

            $form->addError(new FormError('Email / password does not match (email@example.com / password)'));
        }
    }

    return $app['twig']->render('login.html.twig', array('form' => $form->createView()));
})->bind('login');

$app->match('/form', function() use ($app) {

    $builder = $app['form.factory']->createBuilder('form');
    $choices = array('choice a', 'choice b', 'choice c');

    $form = $builder
        ->add('post_code', 'text', array(
            'constraints' => new Constraint(array(
                'validator' => 'postcode',
                'options' => array('locale' => 'en_GB'),
            ))
        ))
        ->add('domain_name', 'text', array(
            'constraints' => new Constraint(array(
                'validator' => 'hostname',
            ))
        ))
        ->add('isbn', 'text', array(
            'constraints' => new Constraint(array(
                'validator' => 'isbn',
            ))
        ))
        ->add('credit_card_number', 'text', array(
            'constraints' => new Constraint(array(
                'validator' => 'creditcard',
            ))
        ))
        ->getForm()
    ;

    if ('POST' === $app['request']->getMethod()) {
        $form->bindRequest($app['request']);
        if ($form->isValid()) {
            $app['session']->setFlash('success', 'The form is valid');
        } else {
            $form->addError(new FormError('This is a global error'));
            $app['session']->setFlash('info', 'The form is bind, but not valid');
        }
    }

    return $app['twig']->render('form.html.twig', array('form' => $form->createView()));
})->bind('form');

$app->match('/logout', function() use ($app) {
    $app['session']->clear();

    return $app->redirect($app['url_generator']->generate('homepage'));
})->bind('logout');

$app->get('/page-with-cache', function() use ($app) {
    $response = new Response($app['twig']->render('page-with-cache.html.twig', array('date' => date('Y-M-d h:i:s'))));
    $response->setTtl(10);

    return $response;
})->bind('page_with_cache');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message, $code);
});

return $app;

<?php
namespace BlogBundle\Controller;

use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AuthController extends Controller {
	private $session;

	public function __construct() {

		$this->session = new Session();

	}

	public function loginAction() {
		$authenticationUtils = $this->get("security.authentication_utils");
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('BlogBundle:Default:login.html.twig', array("error" => $error, "lastUsername" => $lastUsername));
	}

	public function registerAction(Request $request) {
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$user_repo = $em->getRepository("BlogBundle:User");
				$user = $user_repo->findOneBy(array("email" => $form->get('email')->getData()));
				if (count($user) == 0) {
					$user = new User();
					$user->setName($form->get('name')->getData());
					$user->setSurname($form->get('surname')->getData());
					$user->setEmail($form->get('email')->getData());

					$factory = $this->get("security.encoder_factory");
					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword($form->get('password')->getData(), $user->getSalt());
					$user->setPassword($password);
					$user->setRole("ROLE_USER");
					$user->setImage(null);
					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($user);
					$flush = $em->flush();
					if ($flush != null) {
						$status = "Usuario no registrado";
					} else {
						$status = "Usuario Registrado";
					}
				} else {
					$status = "El usuario ya se registro";
				}

			} else {
				$status = "Formulario Invalido";
			}
			$this->session->getFlashBag()->add("session", $status);
		}

		return $this->render('BlogBundle:Default:register.html.twig', array(
			"form" => $form->createView(),
		));
	}
}

?>
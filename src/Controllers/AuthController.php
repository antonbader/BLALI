<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use Models\User;

class AuthController extends Controller {

    public function login() {
        // Wenn schon eingeloggt, redirect
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                $this->redirect('/admin/dashboard');
            } else {
                $this->redirect('/club/dashboard'); // Annahme: Es gibt ein Club Dashboard
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Check
            if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                Session::setFlash('error', 'Ungültige Sitzung. Bitte erneut versuchen.');
                $this->redirect('/auth/login');
            }

            $username = $this->input('username');
            $password = $this->input('password');

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                Auth::login($user);
                Session::setFlash('success', 'Erfolgreich angemeldet.');
                if (Auth::isAdmin()) {
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->redirect('/club/dashboard');
                }
            } else {
                Session::setFlash('error', 'Benutzername oder Passwort falsch.');
            }
        }

        $this->view('auth/login');
    }

    public function logout() {
        Auth::logout();
        Session::setFlash('success', 'Erfolgreich abgemeldet.');
        $this->redirect('/');
    }

    public function changePassword() {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                Session::setFlash('error', 'Ungültige Sitzung.');
                $this->redirect('/auth/changePassword');
            }

            $old = $this->input('old_password');
            $new = $this->input('new_password');
            $confirm = $this->input('confirm_password');

            if ($new !== $confirm) {
                Session::setFlash('error', 'Die neuen Passwörter stimmen nicht überein.');
            } else {
                $userModel = new User();
                $user = $userModel->findByUsername(Session::get('user_name'));

                if (password_verify($old, $user['password'])) {
                    $userModel->updatePassword(Auth::id(), $new);
                    Session::setFlash('success', 'Passwort erfolgreich geändert.');
                    $this->redirect('/');
                } else {
                    Session::setFlash('error', 'Das alte Passwort ist falsch.');
                }
            }
        }

        $this->view('auth/change_password');
    }
}

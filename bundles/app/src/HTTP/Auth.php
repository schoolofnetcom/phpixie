<?php

namespace Project\App\HTTP;

class Auth extends Processor
{

    public function defaultAction($request)
    {
        if($this->user()) {
            return $this->redirect('app.processor');
        }

        $components = $this->components();

        $template = $components->template()->get('app:login', [
            'user' => $this->user()
        ]);

        $loginForm = $this->loginForm();
        $template->loginForm = $loginForm;

        $registerForm = $this->registerForm();
        $template->registerForm = $registerForm;

        if($request->method() !== 'POST') {
            return $template;
        }

        $data = $request->data();

        if ($data->get('register')) {
            $registerForm->submit($data->get());

            if ($registerForm->isValid() && $this->processRegister($registerForm)) {
                return $this->redirect('app.processor');
            }
        } else {
            $loginForm->submit($data->get());

            if($loginForm->isValid() && $this->processLogin($loginForm)) {
                return $this->redirect('app.processor');
            }
        }

        return $template;
    }

    protected function registerForm()
    {
        $validate = $this->components()->validate();
        $validator = $validate->validator();
        $document = $validator->rule()->addDocument();

        $document->allowExtraFields();

        $document->valueField('name')
            ->required("Name is required")
            ->addFilter()
            ->minLength(3)
            ->message("Username must contain at least 3 characters");

        $document->valueField('email')
            ->required("Email is required")
            ->filter('email', "Please provide a valid email");

        $document->valueField('password')
            ->required("Password is required")
            ->addFilter()
            ->minLength(8)
            ->message("Password must contain at least 8 characters");

        $document->valueField('passwordConfirm')
            ->required("Please repeat your password");

        $validator->rule()->callback(function($result, $value) {
            if($value['password'] !== $value['passwordConfirm']) {
                $result->field('passwordConfirm')->addMessageError("Passwords don't match");
            }
        });

        return $validate->form($validator);
    }


    protected function processRegister($registerForm)
    {
        $userRepository = $this->components()->orm()->repository('user');

        if($userRepository->getByLogin($registerForm->email)) {
            $registerForm->result()->field('email')->addMessageError("This email is already taken");
            return false;
        }

        $provider = $this->passwordProvider();
        $user = $userRepository->create([
            'name'  => $registerForm->name,
            'email' => $registerForm->email,
            'password' => $provider->hash($registerForm->password)
        ]);
        $user->save();

        $provider->setUser($user);
        return true;
    }

    protected function processLogin($loginForm)
    {
        $user = $this->passwordProvider()->login(
            $loginForm->email,
            $loginForm->password
        );

        if($user === null) {
            $loginForm->result()->addMessageError("Invalid email or password");
            return false;
        }

        return true;
    }

    public function logoutAction()
    {
        $domain = $this->components()->auth()->domain();
        $domain->forgetUser();

        return $this->redirect('app.frontpage');
    }

    protected function loginForm()
    {
        $validate = $this->components()->validate();
        $validator = $validate->validator();

        $document = $validator->rule()->addDocument();

        $document->valueField('email')
            ->required("Email is required");

        $document->valueField('password')
            ->required("Password is required");

        return $validate->form($validator);
    }

    protected function passwordProvider()
    {
        $domain = $this->components()->auth()->domain();
        return $domain->provider('password');
    }
}
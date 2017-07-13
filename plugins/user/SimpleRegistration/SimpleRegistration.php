<?php
// no direct access
defined( '_JEXEC' ) or die;

class PlgUserSimpleRegistration extends JPlugin
{
protected $autoloadLanguage = true;

function onContentPrepareForm($form, $data)
{
    if (!($form instanceof JForm))
    {
        $this->_subject->setError('JERROR_NOT_A_FORM');
        return false;
    }

    // Check we are manipulating the registration form
    if ($form->getName() != 'com_users.registration')
    {
        return true;
    }

    // Check whether this is frontend or admin
    if (JFactory::getApplication()->isAdmin()) {
        return true;
    }

    // Remove/Hide fields on frontend
    // Note: since the onContentPrepareForm event gets fired also on
    // submission of the registration form, we need to hide rather than
    // remove the mandatory fields. Otherwise, subsequent filtering of the data
    // from within JModelForm.validate() will result in the required fields
    // being stripped from the user data prior to attempting to save the user model,
    // which will trip an error from inside the user object itself on save!
    $form->removeField('password2');
    $form->removeField('email2');

    $form->setFieldAttribute('name', 'type', 'hidden');
    $form->setValue('name', null, 'placeholder');

	$form->setFieldAttribute('mobileno', 'type', 'hidden');
    $form->setValue('mobileno', null, '10000000000');

    //$form->setFieldAttribute('email1', 'type', 'hidden');
   // $form->setValue('email1', null, JUserHelper::genRandomPassword(10) . '@invalid.nowhere');

    // Re-label the username field to 'Email Address' (the Email field
    // ordinarily appears below the password field on the default Joomla
    // registration form)
    //$form->setFieldAttribute('username', 'label', 'COM_USERS_REGISTER_EMAIL1_LABEL');

    return true;
}

function onUserBeforeDataValidation($form, &$user) {
    if ($form->getName() != 'com_users.registration') {
        return true;
    }
/*
    if (!$user['username']) {
        // Keep up the pretense from above!
        $form->setFieldAttribute('username', 'label', 'COM_USERS_REGISTER_EMAIL1_LABEL');
        return true;
    }
*/

		//$user['email2'] =$user['email1'] ;
		//$user['password2'] = $user['password1'];
		//$user['mobileno'] =$user['phoneno'] ;

    if (!$user['name'] or $user['name'] === 'placeholder') {
        $user['name'] = $user['username'];
        $user['email2'] =$user['email1'] ;
        $user['password2'] = $user['password1'];
    }
	if (!$user['mobileno'] or $user['mobileno'] === '10000000000') {
        $user['mobileno'] =$user['phoneno'] ;
    }
}

}


?>
<?php
namespace OpenCFP;

/**
 * Form object for our signup page, handles validation of form data
 */
class SignupForm
{
	protected $_data;
	protected $_passwordMessages = '';

    /**
     * Class constructor
     *
     * @param $data array of $_POST data
     */
    public function __construct($data)
    {
    	$this->_data = $data;
    }

    /**
     * Method verifies we have all required fields in our POST data
     *
     * @returns boolean
     */
    public function hasRequiredFields()
    {
        // If any of our fields are empty, reject stuff
	    $fieldList = array(
	        'email', 
	        'password', 
	        'password2', 
	        'first_name', 
	        'last_name',
	        'speaker_info'
	    );

	    foreach ($fieldList as $field) {
	        if (!isset($this->_data[$field])) {
	            $allFieldsFound = false;
	            break;
	        }
	    }

	    return $allFieldsFound;
	}

	/**
	 * Method that applies validation rules to email 
	 *
	 * @param string $email
	 */
	public function validateEmail()
	{
		if (!isset($this->_data['email'])) {
			return false;
		}

		$response = filter_var($this->_data['email'], FILTER_VALIDATE_EMAIL);

		return ($response !== false);
	}

	/**
	 * Method that applies validation rules to user-submitted passwords
	 *
	 * @return true|string
	 */
	public function validatePasswords()
	{
		$passwd = filter_var($this->_data['password'], FILTER_SANITIZE_STRING);
		$passwd2 = filter_var($this->_data['password2'], FILTER_SANITIZE_STRING);

		if ($passwd == '' || $passwd2 == '') {
			return "Missing passwords";
		}

		if ($passwd !== $passwd2) {
	        return "The submitted passwords do not match";
	    }

	    if (strlen($passwd) < 5 && strlen($passwd2) < 5) {
            return "Your password must be at least 5 characters";
	    }

	    return true; 
	}
}
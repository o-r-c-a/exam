<?php 
    function checkIfAdmin(){
        if($_SESSION['loggedRole']!=='a')
            header('Location: index.php');
    }

    function checkIfLoggedIn(){
        if(empty($_SESSION['loggedRole']))
            header('Location: index.php');
    }
    
    //Truncate: Shortens News text to textPreview length of size 100)
    function truncate($string,$length,$append=" [...]") {
        $string = trim($string); //removes beginning and ending whitespaces
    
        if(strlen($string) > $length) {
        $string = wordwrap($string, $length); //defines where to make \n if needed (not within words!)
        $string = explode("\n", $string, 2); //splits string into two substrings via \n-Token
        $string = $string[0] . $append; //appends "..." at the end
        }
        
        return $string;
    }
    
    function convertTimeStamp($timestamp){
        //Convert timestamp to DD.MM.YYYY
        $time = strtotime($timestamp);
        $formatForView = date("d.m.Y", $time);
        return $formatForView;
    }

    function convertReservationState($state_id){
        switch($state_id){
            case 'n':
                return "Neu <i>(Ausstehend)</i>";
            case 'b':
                return "Bestätigt";
            case 's':
                return "Storniert";
            default:
                return "";
        }
    }

    // SECURITY FUNCTION: this function prevents hackers from inserting a script
    // https://www.w3schools.com/php/php_form_validation.asp
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>
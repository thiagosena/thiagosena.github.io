<?php 

    /*- CONFIGURATION -*/

    /** Where to send the email (your email address) */
    $to = "lord.sena@gmail.com";

    /** What is the name of your website */
    $website_name = "Thiago Sena's Home page";

    /** Which subject to define for the email (what you want to see it as in your list of emails) */
    $subject = "[${website_name}]";

    /** The message minimum and maximum lengths (use -1 for no limit) */
    $msg_min = 10;
    $msg_max = 5000;

    /** The home page (no need to change that unless you rename the home page) */
    $homepage = "index.html";

    /** Change this to your timezone, see http://php.net/manual/en/timezones.php */
    $timezone = "America/Sao_Paulo";

    /** Change this to your locale or leave it blank for the default one on the server */
    $locale = "";

    /** The first line of the email message sent to you (the second line will be when it was sent and who sent it) */
    $email_header = "Voc&ecirc; recebeu uma mensagem atrav&eacute;s de ${website_name}.";

    /** The error to display when it failed to send the email (occurs with server configuration problems, talk to the administrator) */
    $error_msg_failed_to_send = "Ocorreu um erro. Por favor envie-nos um e-mail diretamente at&eacute; resolver o problema. Desculpe o transtorno.";

    /** The message to prefix the error description (for example "Please enter" could give "Please enter a name") */
    $error_msg_please_enter = "Por favor insira";

    /** Error message when the name is missing */
    $error_msg_name = "seu nome";

    /** Error message when the email address is invalid */
    $error_msg_email = "seu endere&ccedil;o de email";

    /** Error message when the message has no minimum and is longer than the maximum (%d represents the limit to display) */
    $error_msg_message_no_longer_than = "uma mensagem de no m&aacute;ximo %d characteres";

    /** Error message when the message has no maximum but is shorter than the minimum (%d represents the limit to display) */
    $error_msg_message_of_at_least = "uma mensagem de, pelo menos %d characteres";

    /** Error message when the message has both a minimum and a maximum but is either too short or too long (%d represents the limits to display) */
    $error_msg_message_between = "uma mensagem entre %d e %d characteres";



    /*- CODE -*/
    $post = !empty( $_POST );

    /* Only send an email if the form was posted to prevent accidental browsing to email you */
    if( $post ) {

        /** This function will validate an email address according to RFC 3696 more or less */
        function ValidateEmail( $email ) {
            $regex = '/\A([a-z0-9!#\$%&\'\+\-\/=\?\^\_`\{\|\}~][a-z0-9!#\$%&\'\+\-\/=\?\^\_`\{\|\}~\.]*)@([a-z0-9][a-z0-9\-]*)(\.[a-z0-9][a-z0-9\-]*)+\Z/i';

            $result = preg_match( $regex, $email );

            return $result !== FALSE && $result > 0;
        }

        /* We filter out what the user sent us by eliminating HTML tags to display them in text. */
        $name = str_replace( "\n", "", htmlspecialchars( trim( $_POST['name'] ) ) );
        $email = htmlspecialchars( trim( $_POST['email'] ) );
        $message = str_replace( "\n", "<br />\n", htmlspecialchars( trim( $_POST['message'] ) ) );


        /* Let's check for errors */
        $error = '';

        /* Do we at least have a name */
        if( !$name ) {
            if( $error != '' ) {
                $error .= ', ';
            }

            $error .= $error_msg_name;
        }

        /* Validate the email address */
        if( !$email || ( $email && !ValidateEmail( $email ) ) ) {
            if( $error != '' ) {
                $error .= ', ';
            }

            $error .= $error_msg_email;
        }

        /* Make sure the message respects the length constraints */
        if( ( $msg_min != -1 && strlen( $message ) < $msg_min ) || ( $msg_max != -1 && strlen( $message ) > $msg_max ) ) {
            if( $error != '' ) {
                $error .= ', ';
            }

            if( $msg_min == -1 ) {
                $error .= sprintf( $error_msg_message_no_longer_than, $msg_max );
            } else if( $msg_max == -1 ) {
                $error .= sprintf( $error_msg_message_of_at_least, $msg_min );
            } else {
                $error .= sprintf( $error_msg_message_between, $msg_min, $msg_max );
            }
        }

        if( !$error ) {
            /* Generate the email */
            $headers = "From: \"${name}\" <${email}>\n";
            $headers.= "Reply-to: ${email}\n";
            $headers.= "MIME-Version: 1.0\n";
            $headers.= "Content-Type: text/html; charset=utf-8\n";

            /* Obtain a timestamp in the proper timezone */
            date_default_timezone_set( $timezone );

            /* Obtain a time string using the specified locale to get the month name */
            setlocale( LC_TIME, $locale );
            $ds = strftime( '%e %B %Y %H:%M' );

            /* Prepare the message body */
            $messages = "${email_header}<br /><br />\n";
            $messages.= "${ds}, ${name} &lt;${email}&gt;:<br /><br />\n";
            $messages.= $message;

            /* Send the email */
        	$mail = mail( $to, $subject, $messages, $headers );

            if( $mail ) {
                /* All is well */
            	echo "OK";
            } else {
                /* You might want to check your server configuration if you see this message (ask the administrator) */
                echo "<div class=\"error\">${error_msg_failed_to_send}</div>";
            }
        }
        else
        {
            /* Display the error message */
            echo "<div class=\"error\">${error_msg_please_enter} ${error}.</div>";
        }
    } else {
        /* Accidental browsing to this page, so let's bring them back to the home page */
        header( "Location: ${homepage}" );
    }
?>
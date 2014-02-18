<?php
     
     echo "<p>GET:</p>";
     var_dump($_GET);

     echo "<p>POST:</p>";
     var_dump($_POST);
?>

<!DOCTYPE html>
<html>
    <head>
         <title>My First HTML Form</title>
    </head>    
    <body>
        <h2> User Login </h2>
        <form method="GET" action="">
            <p>
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder = "Enter username here">
            </p>

            <p>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder = "Enter password here">
            </p>

            <p>
                <button type = "submit">Login</button> 
            </p>
       

        <h2> Compose an email</h1>
        
             <p>
                <label for="to">To:</label>
                <input id="to" name="to" type="text" placeholder = "Enter the mail of the receiver">
            </p>

             <p>
                <label for="from">From:</label>
                <input id="from" name="from" type="text" placeholder = "Enter your email">
            </p>

             <p>
                <label for="subject">Subject:</label>
                <input id="subject" name"subject" type="text" placeholder = "Enter the subject">
            </p>

            <p>
                <label for="bodyemail">Compose Email:</label>
                <textarea id="bodyemail" name="bodyemail" type="text"  rows ="30" cols ="50" placeholder = "Type your message here"></textarea>
            </p>
            
            <p>
               <label for="email_copy">
                     <input type="checkbox" id="email_copy" name="email_copy" value="yes" checked> Do you want to save a copy in your sent folder?
               </label>      
            </p>

            <p>
                <button type = "send"> Send</button> 
            </p>  
       
      
        <h2>Multiple Choice Test</h2>
         
               
               <p>What is your favorite social network?</p>
                  <label for="q1a">
                        <input type="radio" id="q1a" name="q1" value="facebook">
                        Facebook
                 </label>
                <label for="q1b">
                        <input type="radio" id="q1b" name="q1" value="twitter">
                        Twitter
                </label>
                <label for="q1c">
                        <input type="radio" id="q1c" name="q1" value="linkedin">
                        Linkedin
                </label>
                <label for="q1d">
                        <input type="radio" id="q1d" name="q1" value="pin Interest">
                       Pin Interest
                </label>

                <p>Which color do you prefer?</p>
                  <label for="q2a">
                        <input type="radio" id="q2a" name="q2" value="red">
                        Red
                 </label>
                <label for="q2b">
                        <input type="radio" id="q2b" name="q2" value="black">
                        Black
                </label>
                <label for="q2c">
                        <input type="radio" id="q2c" name="q2" value="blue">
                        Blue
                </label>
                <label for="q2d">
                        <input type="radio" id="q2d" name="q2" value="white">
                       White
                </label>

                <p>What cities of Texas do you know?</p>
                    <label for="os1"><input type="checkbox" id="os1" name="os[]" value="linux"> SanAntonio</label>
                    <label for="os2"><input type="checkbox" id="os2" name="os[]" value="osx"> Houston</label>
                    <label for="os3"><input type="checkbox" id="os3" name="os[]" value="windows"> Dallas</label>
                    <label for="os4"><input type="checkbox" id="os4" name="os[]" value="windows"> Austin</label>
                    <label for="os5"><input type="checkbox" id="os5" name="os[]" value="windows"> El Paso</label>
                    <label for="os3"><input type="checkbox" id="os3" name="os[]" value="windows"> Corpus Christi</label>
               
               <p> 
                <label for="apple_products">What Apple products have you used? </label>
                <select id="apple_products" name="apple_products[]" multiple>
                    <option value="Macbook Pro">Mackbook Pro</option>
                    <option value="Macbook Air">Macbook Air</option>
                    <option value="iMac">iMac</option>
                    <option value="Ipad">Ipad</option>
                    <option value="Iphone">Iphone</option>
                </select>
               </p>

        <h2> Select testing </h2>
        
              <label for="like_html">Do you like HTML: </label>
                    <select id="like_html" name="like_html[]">
                    <option value = "1">Yes</option>
                    <option value = "0" selected>No</option>
                    </select>
        </form> 
    </body>
</html>
<?php

 return [
     'superadmin_user_email' => 'admin@codehell.info',

     'skills' => [
         'Admin' => 8,
         'Moderator' => 4,
         'User'  => 2,
         'Guest' => 1,
     ],
     /*
      * Restrict access to forums to users with skill or more
      */
     'forum_access' => [
         '1' => 'Admin',
     ]
 ];
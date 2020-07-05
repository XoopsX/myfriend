## Module MyFriend

### Description  

The module implements an invitation feature, and a list of friends.  
Since you can select the group to register with the invitation function, 
it is possible to separate the invitation group from the normal registration of XCube.
You can prevent XCube user registration unless there is an invitation.

### Custom User Template  

A template of userinfo.php is also available that implements MyFriend features.  
The XCube default template can be replaced with _"templates/myfriend_userinfo.html"_

### Custom Email Template  

The module also features a template to send email invitations :  
_language/language/invitation.tpl_
So, you can edit and rewrite it appropriately.

### Integration  

- Module Private Message  
- Module Pico  

---
### Changelog  

ver2.30: Refactor code to XCL - PHP7 and MySQL ENGINE=InnoDB  

---
Ver0.44: Fixed a bug that the approval of friend application is not reflected in the friend list of the applicant.

Ver0.42: Fixed that the delete link was not displayed even if the user allowed to delete  

Ver0.41: Modified to delete data from myfriend_friendlist when deleting users

Ver0.40: Set the number of days to automatically delete invitations on the management screen
        Invited users can be arbitrarily deleted
        Fixed typo of block file name
        Fixed block disappeared in PHP4

Ver0.32: Invitation automatically deleted after 30 days
        Using Module.class.php

Ver0.31: Abolition of meaningless references
        Changed some require to require_once

Ver0.30: Supports favorite users

Ver0.20: Supports Usersearch module

Ver0.13: Changed to give access right to all groups at installation
        Changed not to register delegate except registered user
        Other minor changes


### ToDo  

- Modify and add blocks
- Modify templates to XCL default UI

For a refactored version of this application, see here : https://github.com/Robert430404/Simple-Note  

Story
--
The firewall at my school was blocking services like iCloud/Evernote so I couldn't use such services whenever I had a new idea in mind.
So I decided to create my own "note web app" just for fun as I'm currently learning web development. It uses SQLite for storing notes and PDO for querying the database.
![Home page](https://user-images.githubusercontent.com/17199757/176432124-2cf49c70-49e2-43a6-a378-fa9cbf6b1b85.png)
![Edit note](https://user-images.githubusercontent.com/17199757/176432137-c837425f-54cd-4dca-95f5-bf4ec8bd873a.png)

Installation
--
Simply clone the project on your server and access it through your browser.
You will be able to see a nice UI with a form on which you can write anything you want.

If I were to improve this...
--
* Protection using a login form or a simple auth basic.
* Set tag for a note.
* Add HTML editor (TinyMCE or something else).
* Delete notes using POST request rather than GET.
* Sort notes by name/date/time.
* Ability to share notes.
* Use AJAX to create/edit/delete notes without having to reload the page.
* JSON API (to use with a Chrome/Firefox extension or a mobile app for example)
* Error handling.

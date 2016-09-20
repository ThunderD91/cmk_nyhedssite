Dette sebsite udleveres til eleverne, så er der et fundament til at lave nyheds site opgaven.

Websitet er struktureret så det er "index.php" der driver alting på frontend, og "admin/index.php" håndeterer alt backend
Det er især backend som kan kræve en forklaring.

"index.php" indlæses, og indeholder alt html + css samt menuer og alt det "statiske"
baseret på URL ?page=xxxxxx inlkuderes den fil som passer
	f.eks. "?page=users" betyder at det er "users.php" der inkluderes
	
	"users.php" fungerer som en slags controller, den sørger for at hente den funktionalitet der ønskes
	baseret på om der er en "action" med i URL... 
	
	"?page=users&action=add" betyder at "users.php" inkluderes, og at users.php sørger for at inkludere "page_function/user_add.php"
	    

	?page=users 						=> users.php => user_list.php
	?page=users&action=add 				=> users.php => user_add.php
	?page=users&action=edit&user_id=1 	=> users.php => user_edit.php
	?page=users&action=delete&user_id=1 => users.php => user_delete.php 
	

Alle områderne i backend, er sat sådan op.
Det er for at man kun skal koncentrere sig om EN ting, nemlig enten at OPRETTE en ting, eller at SLETTE en ting... 


Assets mappen, blev til fordi den er rigtig god til bootstrap og jquery.

/assets/
	/css/
		bootstrap.min.css
		frontend.css
		backend.css
	/ckeditor/
		alt til editoren, når den skal bruges
	/js/
		bootstrap.min.js
		jquery-1.10.2.min.js
	/img/
		...
	/font/
		...
		
Men jeg besluttede at loade bootstrap og jquery fra nettet fra 
http://www.bootstrapcdn.com/ og https://developers.google.com/speed/libraries/devguide?hl=da
så assetsmappen blev ret tom... det er valgfrit hvordan al det med js/css/etc sættes op.

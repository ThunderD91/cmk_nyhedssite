<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=contact'));
    }
?>
<p>
	Skriv en besked til os, og vi vil vende tilbage snarest muligt.
</p>
<form method="post" class="row">
	<fieldset class=" col-lg-4">
		<div class="form-group">
			<label for="contact_name">Dit Navn</label>
			<input type="text" class="form-control" name="contact_name" placeholder="Skriv dit navn" autofocus required />
		</div>
		<div class="form-group">
			<label for="contact_email">Din Email Adresse</label>
			<input type="email" class="form-control" name="contact_email" placeholder="Skriv din email" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required />
		</div>
		<div class="form-group">
			<label for="contact_topic">Emne</label>
			<input type="text" class="form-control" name="contact_topic" placeholder="Skriv emne" required />
		</div>
		<div class="form-group">
			<label for="contact_message">Besked</label>
			<textarea name="contact_message"  class="form-control" placeholder="Skriv din besked" required></textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-default" name="contact_submit" value="Send" />
		</div>
	</fieldset>
</form>

<div class="bottom">
	<ul class="breadcrumb">
		<li>
			<a href="index.php?page=frontpage">Forside</a>
		</li>
		<li class="active">
			Kontakt
		</li>
	</ul>
</div>
<?php
// Reused on new/edit Bird forms. The Bird object is populated before inclusion.
?>
<p><label>Common name (required):
    <input type="text" name="common_name" maxlength="150" required value="<?php print h($bird->common_name); ?>">
</label></p>
<p><label>Scientific name (required):
    <input type="text" name="scientific_name" maxlength="150" required value="<?php print h($bird->scientific_name); ?>">
</label></p>
<p><label>Family name:
    <input type="text" name="family_name" maxlength="150" value="<?php print h($bird->family_name); ?>">
</label></p>
<p><label>Primary habitat:
    <input type="text" name="primary_habitat" maxlength="255" value="<?php print h($bird->primary_habitat); ?>">
</label></p>
<p><label>Seasonal status:
    <input type="text" name="seasonal_status" maxlength="100" value="<?php print h($bird->seasonal_status); ?>">
</label></p>
<p><label>Description:</label></p>
<p><textarea name="description" rows="5" cols="60"><?php print h($bird->description); ?></textarea></p>

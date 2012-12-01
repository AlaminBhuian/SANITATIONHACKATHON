<fieldset>
<legend><span class="bangla">সংযুক্ত কাগজপত্র </span> (Complaints Supporting Documents)</legend>
<form method="post" action="<?php echo site_url();?>complaint/submit_doccument" enctype="multipart/form-data">
  <!-- Fieldset -->
  <p><label>Document Title</label>
    <input class="lf" name="document_title" type="text" value="" />
  </p>
  <p><label><span class="bangla"> অন্যান্য / নোটসঃ </span>(Others/Notes)</label>
    <!-- WYSIWYG editor -->
    <textarea cols="80" rows="3" class="wysiwyg" name="document_other_note"></textarea>
    <!-- End of WYSIWYG editor -->
  </p>
  <p> <span class="label">Upload Document (pdf,doc,xls,jpg,gif, audio, video)</span>
    <input type="file" name="userfile"/>
    <input type="hidden" name="complaint_id" value="<?php echo $complaint_id; ?>" />
    <input class="button" type="submit" value="Upload" />
    <input class="button" type="reset" value="Reset" />
  </p>
</form>
</fieldset>
<fieldset>
<legend>Uploaded Document</legend>
<table cellspacing="0" summary="table" class="broom_table">
  <thead>
    <tr>
      <th scope="col">File Title </th>
      <th scope="col">File Name </th>
      <th scope="col">File Type </th>
      <th scope="col">File Format </th>
      <th scope="col">File Size </th>
      <th scope="col">Upload Date </th>
      <th scope="col">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($get_doccument as $file_info){?>
    <tr class="odd">
      <td><a href="#"><?php echo $file_info['file_title'];?></a></td>
      <td><?php echo $file_info['file_name'];?></td>
      <td>Supporting Doc </td>
      <td>DOC</td>
      <td>500 KB </td>
      <td><?php echo $file_info['upload_date'];?></td>
      <td><a href="<?php echo site_url();?>uploads/<?php echo $file_info['file_name'];?>" class="table_download" title="Download / View">Download/View</a></td>
    </tr>
    <?php }?>
  </tbody>
</table>
</fieldset>

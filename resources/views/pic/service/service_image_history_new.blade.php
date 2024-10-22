<div class="modal fade" id="DetailImage<?php echo $ind->service_d_id ?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:750px; max-height:750px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mr-4" id="myModalLabel">Upload (<?php echo $ind->attribute ?>)  <?php echo $ind->service_d_id ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <div class="modal-body" id="dynamicModalBody<?php echo $ind->service_d_id ?>"></div>
        </div>
    </div>
</div>



<script>
    function showModal(id, title, ext) {
        var url = "{{ url('bengkel/report/get-image-service-detail/') }}/" + title;
        // var url = "https://ts3.co.id/bengkel/report/get-image-service-detail/" + title;
        var modalBody = document.getElementById('dynamicModalBody' + id);
        modalBody.innerHTML = '';

        if (ext === 'png' || ext === 'jpg') {
            var img = document.createElement('img');
            img.src = url;
            img.style.width = '65%';
            img.style.height = 'auto';
            modalBody.appendChild(img);
        } else if (ext === 'mp4') {
            var video = document.createElement('video');
            video.id = 'video_' + id; // Give an ID to the video element
            video.width = 640;
            video.height = 440;
            video.controls = true;

            var source = document.createElement('source');
            source.src = url;
            source.type = "video/mp4";

            video.appendChild(source);
            modalBody.appendChild(video);
        }

       


		var myModalElement = document.getElementById('DetailImage' + id);
        var myModal = new bootstrap.Modal(myModalElement);

		var myModalElement = $('#DetailImage' + id);
        var myModal = new bootstrap.Modal(myModalElement[0]);

        // Add event listener using jQuery
        myModalElement.on('hidden.bs.modal', function () {
            var video = document.getElementById('video_' + id);
            if (video) {
                video.pause(); // Pause the video
                video.currentTime = 0; // Reset the video to the start
            }
            modalBody.innerHTML = ''; // Clear modal body content
        });

        myModal.show();


    }
</script>

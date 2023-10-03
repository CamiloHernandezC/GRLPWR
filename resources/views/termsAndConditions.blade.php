<br />
<div class="form-check m-auto">
    <input class="form-check-input" type="checkbox" name="aceptacion" id="aceptacion" required>

    <label class="form-check-label terms-label" for="aceptacion">
        <small>He leido y acepto los <a style="text-decoration: none" href="javascript:void(0);" data-toggle="modal" data-target="#modalTerminos"><b><u>Términos de Servicio</u></b></a> y el <a style="text-decoration: none" href="javascript:void(0);" data-toggle="modal" data-target="#modalConsentimiento"><b><u>Consentimiento Informado</u></b></a></small>
    </label>
</div>

@push('modals')
    <!-- Modal terminos y condiciones-->
    <div class="modal m-auto" tabindex="-1" role="dialog" id="modalTerminos" style="height: 100vh; width: 75vw; z-index: 1051">
        <div role="document" class="m-auto h-100 w-100">
            <div class="modal-content h-100">
                <div class="modal-header h-100">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <object data="https://drive.google.com/file/d/1tqjcPDTw0j4S6IgAQnpz1IH0vE_mxaGa/preview?usp=share_link" type="application/pdf" frameborder="0" width="100%" height="100%" style="padding: 20px;">
                        <embed src="https://drive.google.com/file/d/1tqjcPDTw0j4S6IgAQnpz1IH0vE_mxaGa/preview?usp=share_link" type='application/pdf' width="100%" height="100%" />
                    </object>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal m-auto" tabindex="-1" role="dialog" id="modalConsentimiento" style="z-index: 1051!important; height: 100vh; width: 75vw;">
        <div role="document" class="m-auto h-100 w-100">
            <div class="modal-content h-100">
                <div class="modal-header h-100">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <object data="https://drive.google.com/file/d/1tjTuDN1YO9v0H7epzbdqryguXMh8S1MF/preview?usp=share_link" type="application/pdf" frameborder="0" width="100%" height="100%" style="padding: 20px;">
                        <embed src="https://drive.google.com/file/d/1tjTuDN1YO9v0H7epzbdqryguXMh8S1MF/preview?usp=share_link" type='application/pdf' width="100%" height="100%" />
                    </object>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
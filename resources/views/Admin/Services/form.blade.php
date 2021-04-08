<div class="modal fade bd-example-modal-lg" id="formModel" tabindex="-1" role="dialog"
     aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formSubmit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titleOfModel"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الاسم بالعربية</label>
                                <input type="text" id="name_ar" name="name_ar" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الاسم بالانجليزية</label>
                                <input type="text" id="name_en" name="name_en" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">سعر الدقيقة</label>
                                <input type="number" step="0.01" id="pricePerMinute" name="pricePerMinute" required
                                       class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">سعر كتابة النص للدقيقة</label>
                                <input type="number" step="0.01" id="textPricePerMinute" name="textPricePerMinute"
                                       required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">سعر الترجمة للدقيقة فيديو واحد</label>
                                <input type="number" step="0.01" id="twoLangPricePerMinuteOneVideo"
                                       name="twoLangPricePerMinuteOneVideo" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email"> سعر الترجمة للدقيقة فيديوهين</label>
                                <input type="number" step="0.01" id="twoLangPricePerMinuteTwoVideo"
                                       name="twoLangPricePerMinuteTwoVideo" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email"> سعر التعليق الصوتي للدقيقة</label>
                                <input type="number" step="0.01" id="voiceOverPricePerMinute"
                                       name="voiceOverPricePerMinute" required class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email"> سعر مقاس الفيديو الزائد للدقيقة</label>
                                <input type="number" step="0.01" id="priceBySize" name="priceBySize" required
                                       class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الصوره</label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الفيديو</label>
                                <input type="file" id="video" name="video" class="form-control">
                            </div>
                        </div>

                    </div>
                </div>
                <div id="err"></div>
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="submit" id="save" class="btn btn-success"><i class="ti-save"></i> حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

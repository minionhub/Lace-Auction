@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">@lang('Product Name')</label>
                                    <input type="text" id="name" name="name" placeholder="Name"
                                        class="form-control" value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">@lang('Category')</label>
                                    <select class="form-control" id="category" name="category_id" required="">
                                        <option value="">-- @lang('Select One') --</option>
                                        @forelse($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $product->category_id == $item->id ? 'selected' : null }}>
                                                {{ __(@$item->name) }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">@lang('Start Date')</label>
                                    <input type="text" id="start_date" class="form-control timepicker"
                                        placeholder="@lang('Date')"
                                        value="{{ \Carbon\Carbon::parse($product->start_date)->format('Y-m-d h:i a') }}"
                                        autocomplete="off" name="start_date" required="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('End Date')</label>
                                    <input type="text" class="form-control timepicker" placeholder="@lang('Date')"
                                        value="{{ \Carbon\Carbon::parse($product->end_date)->format('Y-m-d h:i a') }}"
                                        autocomplete="off" name="end_date" required="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>@lang('Minimum Bid Price')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="@lang('Price')"
                                            name="min_bid_price" value="{{ getAmount($product->min_bid_price) }}" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{ $general->cur_text }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>@lang('Stock')</label>
                                    <input type="number" class="form-control" name="stock" value="{{ $product->stock }}" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>@lang('Shipping Cost')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="@lang('Shipping')"
                                            name="shipping_cost" value="{{ getAmount($product->shipping_cost) }}" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{ $general->cur_text }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('Delivery Time')</label>
                                    <input type="text" class="form-control" name="delivery_time"
                                        value="{{ $product->delivery_time }}" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>@lang('Keywords') - </label>
                                    <small>@lang('Separate multiple keywords by') <code>,</code>(comma)
                                        or <code>enter</code> key</small>
                                    <!-- Multiple select-2 with tokenize -->
                                    <select class="select2-auto-tokenize" name="keywords[]" multiple="multiple">
                                        @if ($product->keywords)
                                            @foreach ($product->keywords as $item)
                                                <option value="{{ $item }}" selected>{{ $item }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex; flex-direction: row-reverse;">


                                <div class="col-md-2 imageItem"
                                    style="width: 20%; max-width: 20%; flex: 1; align-self: center;">
                                    <div class="payment-method-item">
                                        <div class="payment-method-header d-flex flex-wrap">
                                            <div class="thumb" style="position: relative; width: 100%; margin-bottom: 0;">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview">
                                                        @if ($product->pdf)
                                                            <iframe id="pdfPreview"
                                                                src="{{ asset('assets/pdf/' . $product->pdf) }}"
                                                                style="width: 100%; height: 100%; border: none;"></iframe>
                                                        @else
                                                            <img id="imagePreview"
                                                                src="{{ asset('assets/images/document.png') }}"
                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" name="pdf" class="profilePicUpload"
                                                        id="pdf_selection" accept=".pdf" onchange="previewFile()" />
                                                    <label for="pdf_selection" class="bg-primary"><i
                                                            class="la la-pencil"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group form-edit-custom" style="width: 80%; margin-right: auto;">
                                    <label for="nicEditor0">@lang('Description')</label>
                                    <textarea rows="10" name="description" class="form-control nicEdit" id="nicEditor0">{{ $product['description'] }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="card border--dark mb-4">
                                    <div class="card-header bg--dark d-flex justify-content-between">
                                        <h5 class="text-white">@lang('Images')</h5>
                                        <button type="button" class="btn btn-sm btn-outline-light addBtn"><i
                                                class="fa fa-fw fa-plus"></i>@lang('Add New')
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <p><small class="text-facebook">@lang('Images will be resize into')
                                                800x800px</small></p>
                                        <div class="row element">

                                            @forelse($product->images as $image)
                                                <div class="col-md-2 imageItem" id="imageItem{{ $loop->iteration }}">
                                                    <div class="payment-method-item">
                                                        <div class="payment-method-header d-flex flex-wrap">
                                                            <div class="thumb" style="position: relative;">
                                                                <div class="avatar-preview">
                                                                    <div class="profilePicPreview"
                                                                        style="background-image: url('{{ getImage(imagePath()['products']['path'] . '/' . $image) }}')">

                                                                    </div>
                                                                </div>

                                                                <div class="avatar-remove">
                                                                    <button class="bg-danger deleteOldImage"
                                                                        onclick="return false"
                                                                        data-removeindex="imageItem{{ $loop->iteration }}"
                                                                        data-deletelink="{{ route('admin.products.image.delete', [$product->id, $image]) }}"><i
                                                                            class="la la-close"></i></button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="card border--dark">
                                    <h5 class="card-header bg--dark">@lang('Other Information')
                                        <button type="button"
                                            class="btn btn-sm btn-outline-light float-right addNewInformation">
                                            <i class="la la-fw la-plus"></i>@lang('Add New')
                                        </button>
                                    </h5>

                                    <div class="card-body">
                                        <div class="row addedField">

                                            @forelse($product->others_info as $key => $info)
                                                <div class="col-md-12 other-info-data">
                                                    <div class="form-group">
                                                        <div class="input-group mb-md-0 mb-4">
                                                            <div class="col-md-4">
                                                                <input name="title[]" value="{{ $key }}"
                                                                    class="form-control" type="text" required
                                                                    placeholder="@lang('Title')">
                                                            </div>
                                                            <div class="col-md-6 mt-md-0 mt-2">
                                                                <input name="content[]" value="{{ $info }}"
                                                                    class="form-control" type="text" required
                                                                    placeholder="@lang('Content')">
                                                            </div>
                                                            <div class="col-md-2 mt-md-0 mt-2 text-right">
                                                                <span class="input-group-btn">
                                                                    <button
                                                                        class="btn btn--danger btn-lg removeInfoBtn w-100"
                                                                        type="button">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100">@lang('Update')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <a href="{{ route('admin.products.all') }}" class="btn btn-sm btn--primary box--shadow1 text-white text--small"><i
            class="fa fa-fw fa-backward"></i>@lang('Go Back')</a>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('style')
    <style>
        .avatar-remove {
            position: absolute;
            bottom: 180px;
            right: 0;
        }

        .avatar-remove label {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 15px;
            cursor: pointer;
        }

        .avatar-remove button {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            text-align: center;
            line-height: 15px;
            font-size: 15px;
            cursor: pointer;
            padding-left: 6px;
        }

        .form-edit-custom>div {
            width: 100% !important;
        }
    </style>
@endpush

@push('script')
    <script>
        function previewFile() {
            var fileInput = document.getElementById("pdf_selection");
            var pdfPreview = document.getElementById("pdfPreview");
            var imagePreview = document.getElementById("imagePreview");
            var file = fileInput.files[0];

            if (file) {
                if (file.type === "application/pdf") {
                    // Display PDF
                    pdfPreview.style.display = "block";
                    pdfPreview.src = URL.createObjectURL(file);
                    imagePreview.style.display = "none";
                } else if (file.type.startsWith("image/")) {
                    // Display image
                    imagePreview.style.display = "block";
                    imagePreview.src = URL.createObjectURL(file);
                    pdfPreview.style.display = "none";
                } else {
                    // Unsupported file type
                    alert("Unsupported file type. Please select a PDF or image.");
                    pdfPreview.style.display = "none";
                    imagePreview.style.display = "none";
                }
            }
        }

        (function($) {
            "use strict";

            //Delete Old Image
            $('.deleteOldImage').on('click', function() {
                var url = $(this).data('deletelink');
                var removeindex = $(this).data('removeindex');

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(data) {
                        if (data.success) {
                            $('#' + removeindex).remove();
                            notify('success', data.message);
                        } else {
                            notify('error', 'Failed to delete the image!')
                        }
                    }
                });
            });

            // js for Multiple select-2 with tokenize
            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [',']
            });

            // Date time picker
            var start = new Date(),
                prevDay,
                startHours = 12;

            // 12:00 AM
            start.setHours(12);
            start.setMinutes(0);

            // If today is Saturday or Sunday set 10:00 AM
            if ([6, 0].indexOf(start.getDay()) != -1) {
                start.setHours(12);
                startHours = 12
            }
            // date and time picker
            $('.timepicker').datepicker({
                timepicker: true,
                language: 'en',
                dateFormat: 'yyyy-mm-dd',
                startDate: start,
                minHours: startHours,
                maxHours: 24,
                onSelect: function(fd, d, picker) {
                    // Do nothing if selection was cleared
                    if (!d) return;

                    var day = d.getDay();

                    // Trigger only if date is changed
                    if (prevDay != undefined && prevDay == day) return;
                    prevDay = day;

                    // If chosen day is Saturday or Sunday when set
                    // hour value for weekends, else restore defaults
                    if (day == 6 || day == 0) {
                        picker.update({
                            minHours: 24,
                            maxHours: 24
                        })
                    } else {
                        picker.update({
                            minHours: 24,
                            maxHours: 24
                        })
                    }
                }
            });

            var counter = 0;
            $('.addBtn').click(function() {
                counter++;
                $('.element').append(`<div class="col-md-2 imageItem"><div class="payment-method-item"><div class="payment-method-header d-flex flex-wrap"><div class="thumb" style="position: relative;"><div class="avatar-preview"><div class="profilePicPreview" style="background-image: url('{{ asset('assets/images/default.png') }}')"></div></div><div class="avatar-edit"><input type="file" name="images[]" class="profilePicUpload" required id="image${counter}" accept=".png, .jpg, .jpeg" /><label for="image${counter}" class="bg-primary"><i class="la la-pencil"></i></label></div>
                <div class="avatar-remove">
                    <label class="bg-danger removeBtn">
                        <i class="la la-close"></i>
                    </label>
                </div>
                </div></div></div></div>`);
                remove()
                upload()
            });

            function remove() {
                $('.removeBtn').on('click', function() {
                    $(this).parents('.imageItem').remove();
                });
            }

            function upload() {
                function proPicURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var preview = $(input).parents('.thumb').find('.profilePicPreview');
                            $(preview).css('background-image', 'url(' + e.target.result + ')');
                            $(preview).addClass('has-image');
                            $(preview).hide();
                            $(preview).fadeIn(65);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $(".profilePicUpload").on('change', function() {
                    proPicURL(this);
                });
            }

            //----- Add Information fields-------//
            $('.addNewInformation').on('click', function() {
                var html = `
                <div class="col-md-12 other-info-data">
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-4">
                                <input name="title[]" class="form-control" type="text" required placeholder="@lang('Title')">
                            </div>
                            <div class="col-md-6 mt-md-0 mt-2">
                                <input name="content[]" class="form-control" type="text" required placeholder="@lang('Content')">
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="btn btn--danger btn-lg removeInfoBtn w-100" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('.addedField').append(html);
            });

            $(document).on('click', '.removeInfoBtn', function() {
                $(this).closest('.other-info-data').remove();
            });

        })(jQuery);
    </script>
@endpush

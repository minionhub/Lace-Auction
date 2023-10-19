@extends($activeTemplate.'layouts.master')
@section('content')
    <div class="ptb-120">
        <div class="container ml-b-30">

            <div class="card bg-white-smoke custom-box-shadow">
                <div class="card-body p-5">
                    <form action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data"
                          onsubmit="return submitUserForm();">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}"
                                       class="form-controller form-control-lg" placeholder="@lang('Enter Name')" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">@lang('Email address')</label>
                                <input type="email" name="email" value="{{@$user->email}}"
                                       class="form-controller form-control-lg" placeholder="@lang('Enter your Email')"
                                       required>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="website">@lang('Subject')</label>
                                <input type="text" name="subject" value="{{old('subject')}}"
                                       class="form-controller form-control-lg" placeholder="@lang('Subject')">
                            </div>
                            <div class="col-12 form-group">
                                <label for="inputMessage">@lang('Message')</label>
                                <textarea name="message" id="inputMessage" rows="6"
                                          class="form-controller form-control-lg">{{old('message')}}</textarea>
                            </div>
                        </div>

                        <div class="row form-group ">
                            <div class="col-sm-9 file-upload">

                                <div class="position-relative mb-2">
                                    <input type="file" name="attachments[]" id="inputAttachments"
                                           class="form-controller custom--file-upload"/>
                                    <label for="inputAttachments">@lang('Attachments')</label>
                                </div>

                                <div id="fileUploadsContainer"></div>
                                <p class="ticket-attachments-message text-muted">
                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                    .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                </p>
                            </div>

                            <div class="col-sm-1 mt-2">
                                <button type="button" class="btn btn-success btn-sm" onclick="extraTicketAttachment()">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>



                        <div class="row form-group justify-content-center">
                            <div class="col-md-12">
                                <button class=" btn btn-danger" type="button" onclick="formReset()">
                                    &nbsp;@lang('Cancel')</button>
                                <button class="btn btn-success" type="submit" id="recaptcha"><i
                                        class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('script')
    <script>
        "use strict";

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append(`<div class="position-relative mb-2">
                            <input type="file" name="attachments[]" id="inputAttachments"
                                   class="form-controller custom--file-upload"/>
                            <label for="inputAttachments">Attachments</label>
                        </div>`)
        }

        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endpush

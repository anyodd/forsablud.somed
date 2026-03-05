@include('layouts.scripts')

<!-- Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        $(document).ajaxError(function(event, xhr, settings, thrownError) {
            var response = xhr.responseJSON;
            var message = response.message ? response.message : '';
            var type = 'warning';
            var reload = false;

            if (xhr.status == 422) {
                var iter = 0;
                message = '';
                type = 'warning';

                $('.form.needs-validation').find('input, select, textarea').removeClass('is-invalid');
                $('.form.needs-validation').find('.select2').removeClass('border border-danger');
                $.each(response.errors, function(name, messages) {
                    if (iter) {
                        message += '<br>';
                    }

                    message += '- ' + messages.join('<br>');
                    iter++;

                    if (name.includes('.')) {
                        name = name.split('.');

                        if (name.length < 3) {
                            $('[name^="' + name[0] + '[]"]').addClass('is-invalid');
                            $('.select2[name^="' + name[0] + '[]"]').next('.select2').addClass(
                                'border border-danger');
                            $('[name^="' + name[0] + '[' + name[1] + ']"]').addClass(
                                'is-invalid');
                            $('.select2[name^="' + name[0] + '[' + name[1] + ']"]').next(
                                '.select2').addClass('border border-danger');
                        } else {
                            $('[name^="' + name[0] + '[' + name[1] + '][' + name[2] + ']"]')
                                .addClass('is-invalid');
                            $('.select2[name^="' + name[0] + '[' + name[1] + '][' + name[2] +
                                ']"]').next('.select2').addClass('border border-danger');
                        }
                    } else {
                        $('[name="' + name + '"]').addClass('is-invalid');
                        $('.select2[name="' + name + '"]').next('.select2').addClass(
                            'border border-danger');
                    }
                });
            } else if (xhr.status == 401 || xhr.status == 419) {
                message = 'Sesi login habis, browser akan dimuat ulang dan silakan login kembali.';
                type = 'warning';
                reload = true;
                $('.modal').modal('hide');
            } else if (xhr.status == 500) {
                message = 'Terjadi kesalahan, silakan hubungi Admin.';
                type = 'error';
                reload = false;
                $('.modal').modal('hide');
            }

            if (response.action && response.action == 'posting') {
                showErrorTable(response.errors);
            } else if (response.action && response.action == 'posting-table') {
                showErrorTableCustom(response.table);
                showAlert(message, type, false);
            } else {
                showAlert(message, type, reload);
            }

            hideLoading();
        });

        $(document).on('show.bs.modal', '#modal', function(event) {
            var url = $(event.relatedTarget).attr('href');
            var title = $(event.relatedTarget).attr('title');
            var action = $(event.relatedTarget).data('action');
            var code = $(event.relatedTarget).data('code');
            var code_perkada = $(event.relatedTarget).data('code_perkada');
            var modalSize = $(event.relatedTarget).data('modal-size');
            var modal = $(this);
            modal.find('.modal-title').html(title);
            modal.find('.modal-body').html(setLoader());

            if (action == 'delete' || action == 'unposting' || modalSize) {
                modal.find('.modal-dialog').removeClass('modal-xl');

                if (modalSize) {
                    modal.find('.modal-dialog').addClass('modal-' + modalSize);
                }
            } else {
                modal.find('.modal-dialog').addClass('modal-xl');
            }

            $.get(url, {
                action: action,
                code: code,
                code_perkada: code_perkada,
            }, function(response) {
                modal.find('.modal-body').html(response.form);
                initSelect2();
                initDataTable();
                initInputMask();
                //initMaxLength();

                if (action == 'wizard') {
                    initFormWizard(modal.find('form'));
                    initRepeater();
                }

                // Custom function that triggered after this ajax, can be created any page
                if (typeof onShowForm === "function") {
                    onShowForm(response.param);
                }
            });
        });

        $(document).on('submit', '.form', function(event) {
            event.preventDefault();
            var form = $(this);
            var formData = new FormData($(this)[0]);
            showLoading();

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var rowid = '';
                    var draw = false;
                    var reset = response.reset ? true : false;
                    $('#modal').modal('hide');
                    showAlert(response.message);
                    closeFormControl(form, reset);

                    if (typeof tableDetail !== 'undefined') {
                        rowid = $(tableDetail.table().container()).closest('tr').data('id');

                        if (rowid == undefined) {
                            tableDetail.draw(draw);
                        }
                    }

                    $('#tab-parent > .tab-pane.active input[name="rowid"]').val(rowid);

                    if (typeof table !== 'undefined') {
                        if ($.isArray(table)) {
                            var index = $('#tab-parent > .tab-pane').index($(
                                '#tab-parent > .tab-pane.active'));

                            if (typeof table[index] !== 'undefined') {
                                table[index].draw(draw);
                            }
                        } else {
                            table.draw(draw);
                        }
                    }

                    // Update orgChart
                    if (typeof refreshChart === "function") {
                        refreshChart();
                    }

                    if (response.redirect) {
                        location.href = response.redirect;
                    } else {
                        hideLoading();
                    }
                }
            });
        });

        $(document).on('click', '.btn-file-upload', function() {
            openFileUpload(this);
        });

        $(document).on('change', '.input-file-upload', function() {
            $(this).closest('form').trigger('submit');
        });

        $(document).on('input', 'input.pagu_tahun', function() {
            var total_nominal = 0;
            var total_decimal = 0;
            var total_pagu = 0;

            $('input.pagu_tahun').each(function() {
                total_pagu += parseFloat($(this).val().replace(',', '').split('.').join(''));
            });

            total_nominal = total_pagu.toString().slice(0, -2);
            total_decimal = total_pagu.toString().slice(-2);
            total_pagu = [total_nominal, total_decimal].join(',');

            $('input#total_pagu').val(total_pagu);
        });
    });

    function openFormControl(form) {
        $(form).find('.form-control-plaintext').removeClass('form-control-plaintext').addClass('form-control').attr(
            'readonly', false);
        $(form).find('#open-form-control').addClass('d-none');
        $(form).find('#close-form-control').removeClass('d-none');
    }

    function closeFormControl(form, reset) {
        if (reset) {
            $(form).trigger('reset');
        }

        $(form).find('.form-control').removeClass('form-control').addClass('form-control-plaintext').attr('readonly',
            true);
        $(form).find('#open-form-control').removeClass('d-none');
        $(form).find('#close-form-control').addClass('d-none');
    }

    function openFileUpload(button) {
        $(button).parent().find('.input-file-upload').trigger('click');
    }

    function initRepeater() {
        $('.repeater-custom-show-hide').repeater({
            show: function() {
                $(this).find('input, select, textarea').each(function() {
                    $(this).val(this.defaultValue);
                });

                $(this).slideDown();
            },
            hide: function(remove) {
                if (confirm('Are you sure you want to remove this item?')) {
                    $(this).slideUp(remove);
                }
            }
        });
    }

    function showErrorTable(errors) {
        var errorTable = '#table-error';
        var errorTableElm = '';
        var iter = 1;

        if ($.fn.DataTable.isDataTable(errorTable)) {
            $(errorTable).DataTable().destroy();
            $(errorTable).closest('.table-responsive').remove();
        }

        $.each(errors, function(name, messages) {
            errorTableElm += '<tr>' +
                '<td class="text-center">' + iter + '</td>' +
                '<td>' + messages.join('<br>') + '</td>' +
                '</tr>';
            iter++;
        });

        $('#modal .modal-body').append('<div class="table-responsive mt-5">' +
            '<table class="table" id="table-error">' +
            '<thead class="bg-danger text-center">' +
            '<tr>' +
            '<th class="text-white">No</th>' +
            '<th class="text-white">Pesan Error</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            errorTableElm +
            '</tbody>' +
            '</table>' +
            '</div>');

        $(errorTable).DataTable();
        $('#modal').animate({
            scrollTop: $(errorTable).offset().top
        }, 500);
    }

    function showErrorTableCustom(table) {
        var errorTable = '#table-error';
        var errorTableHead = '';
        var errorTableBody = '';

        if ($.fn.DataTable.isDataTable(errorTable)) {
            $(errorTable).DataTable().destroy();
            $(errorTable).closest('.table-responsive').remove();
        }

        $.each(table.head, function(key, messages) {
            errorTableHead += '<th class="text-white">' + messages + '</th>';
        });

        $.each(table.body, function(key, elm) {
            var errorTableElm = '';

            $.each(elm, function(index, messages) {
                if (isNaN(messages)) {
                    errorTableElm += '<td>' + messages + '</td>';
                } else {
                    errorTableElm += '<td class="text-right">' + messages.toLocaleString('id-ID', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) +
                        '</td>';
                }
            });

            errorTableBody += '<tr>' +
                '<td class="text-center">' + (key + 1) + '</td>' +
                errorTableElm +
                '</tr>';
        });

        $('#modal .modal-body').append('<div class="table-responsive mt-5">' +
            '<table class="table" id="table-error">' +
            '<thead class="bg-danger text-center">' +
            '<tr>' +
            '<th class="text-white">No</th>' +
            errorTableHead +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            errorTableBody +
            '</tbody>' +
            '</table>' +
            '</div>');

        $(errorTable).DataTable();
        $('#modal').animate({
            scrollTop: $(errorTable).offset().top
        }, 500);
    }
</script>

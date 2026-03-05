<script type="text/javascript">
    $(function() {
        setMinHeight();
        initTooltip();
        initSelect2();
        //initMaxLength();
        hideLoading();

        @if(session('message'))
            showAlert('{{ session('message') }}', '{{ session('type') ?? 'success' }}');
        @endif

        $('[type="submit"]').on('submit', function() {
            $(this).addClass('disabled').attr('disabled', true);
        });

        $(document).ajaxStart(function() {
            $('form [type="submit"]').addClass('disabled').attr('disabled', true);
        });

        $(document).ajaxComplete(function() {
            $('form [type="submit"]').removeClass('disabled').attr('disabled', false);
            initInputMask();
        });

        $(document).on('hidden.metisMenu', function(event) {
            $(event.target).find('li.mm-active a').attr('aria-expanded', false);
            $(event.target).find('li.mm-active ul').removeClass('mm-show');
            $(event.target).find('li.mm-active').removeClass('mm-active');
        });

        $(document).on('input', 'input, textarea', function() {
            $(this).removeClass('is-invalid');
        });

        $(document).on('change', 'input, select', function() {
            $(this).removeClass('is-invalid');
        });

        $(document).on('change', 'input[type="text"], textarea', function() {
            this.value = $.trim(this.value);
        });

        $(document).on('shown.bs.modal', '.modal-2', function(event) {
            $('.modal-backdrop:eq(1)').css('z-index', '1050');
        });

        $(document).on('hidden.bs.modal', '.modal-2', function(event) {
            $('body').addClass('modal-open');
        });

        $(document).on('click', '.color-schema', function() {
            setColorSchema($(this).val())
        });

        $(document).on('resize', function() {
            setMinHeight();
        });

        $(document).on('click', 'tr.row-checkbox td:not(:first-child)', function() {
            $(this).closest('tr.row-checkbox').find('input[type="checkbox"]').trigger('click');
        });

        $(document).on('click', '.left-sidenav-wrapper', function () {
            $('.button-menu-mobile').trigger('click');
        });

        // Global Settings DataTables Search
        $(document).on('init.dt', function (e, settings) {
            var api = new $.fn.dataTable.Api(settings);
            var inputs = $(settings.nTable).closest('.dataTables_wrapper').find('.dataTables_filter input');

            inputs.unbind();
            inputs.each(function (e) {
                var input = this;
                disableSubmitOnEnter($(input).closest('form'));

                $(input).bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        api.search(this.value).draw();
                    }
                });

                $(input).bind('input', function (e) {
                    if (this.value == '') {
                        api.search(this.value).draw();
                    }
                });
            });
        });
    });

    function showAlert(message, type = 'success', reload = false) {
        if (type == 'success') {
            $('.alert-message').html(message);
            $('.alert').removeClass('show').addClass('hide');
            $('.alert-' + type).removeClass('hide').addClass('show');
            $('.alert-' + type).fadeTo(5000, 500).slideUp(1000, function() {
                hideAlert(type);
            });
        } else {
            if (type == 'danger') {
                type = 'error';
            }

            Swal.fire({
                title: type.toUpperCase()+'!',
                html: message,
                icon: type
            }).then((result) => {
                if (result.isConfirmed) {
                    if (reload) {
                        showLoading();
                        window.location.reload();
                    }
                }
            });
        }
    }

    function initTooltip() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    //function initMaxLength() {
    //    $('[maxlength]').maxlength({
    //        alwaysShow: true,
    //        warningClass: "badge badge-info",
    //        limitReachedClass: "badge badge-danger"
    //    });
    //}

    function showLoading() {
        $('.preloader').fadeIn();
    }

    function hideLoading() {
        $('.preloader').fadeOut();
    }

    function setMinHeight() {
        $('.page-content').css('min-height', $(window).height() - $('.topbar').height() - $('footer').height());
    }

    function initSelect2() {
        $('select.select2:not(.select2-hidden-accessible)').select2({
            allowClear: false,
            width: '100%'
        });
    }

    function initDataTable() {
        $('table.datatable').DataTable();
    }

    function hideAlert(type = 'success') {
        $('.alert-' + type).removeClass('show').addClass('hide');
    }

    function setLoader() {
        return '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>';
    }

    function initInputMask() {
        $('.inputmask, [data-inputmask], [data-inputmask-mask], [data-inputmask-alias],[data-inputmask-regex]').each(function (ndx, lmnt) {
			if (lmnt.inputmask === undefined) {
				Inputmask().mask(lmnt);
			}
		});
    }

    function disableSubmitOnEnter(form) {
        if (form.length) {
            form.on('keyup keypress', function (e) {
                var keyCode = e.keyCode || e.which;

                if (keyCode == 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }
    }
</script>

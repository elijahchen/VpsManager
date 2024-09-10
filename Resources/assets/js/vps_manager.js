$(document).ready(function() {
    // Initialize DataTable with Material Design styling
    $('#vps-table').DataTable({
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search...",
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        initComplete: function () {
            $('.dataTables_filter input[type="search"]').addClass('form-control');
        }
    });

    // Color-code expiration days
    $('.expiration-days').each(function() {
        var days = $(this).data('days');
        if (days > 15) {
            $(this).addClass('text-success');
        } else if (days > 7) {
            $(this).addClass('text-warning');
        } else if (days > 3) {
            $(this).addClass('text-orange');
        } else {
            $(this).addClass('text-danger');
        }
    });

    // Restart VPS
    $('.restart-btn').click(function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to restart this VPS?')) {
            $.post('/vps-manager/restart/' + id, { _token: $('meta[name="csrf-token"]').attr('content') })
                .done(function() {
                    location.reload();
                })
                .fail(function() {
                    alert('Failed to restart VPS. Please try again.');
                });
        }
    });

    // Terminate VPS
    $('.terminate-btn').click(function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to terminate this VPS? This action cannot be undone.')) {
            $.post('/vps-manager/terminate/' + id, { _token: $('meta[name="csrf-token"]').attr('content') })
                .done(function() {
                    location.reload();
                })
                .fail(function() {
                    alert('Failed to terminate VPS. Please try again.');
                });
        }
    });

    // Report Issue
    $('.report-btn').click(function() {
        var id = $(this).data('id');
        $.post('/vps-manager/report-issue/' + id, { _token: $('meta[name="csrf-token"]').attr('content') })
            .done(function() {
                alert('Issue reported successfully.');
            })
            .fail(function() {
                alert('Failed to report issue. Please try again.');
            });
    });

    // Send Notice
    $('.notice-btn').click(function() {
        var id = $(this).data('id');
        $.post('/vps-manager/send-notice/' + id, { _token: $('meta[name="csrf-token"]').attr('content') })
            .done(function() {
                alert('Notice sent successfully.');
            })
            .fail(function() {
                alert('Failed to send notice. Please try again.');
            });
    });

    // Extend Expiration
    $('.extend-btn').click(function() {
        var id = $(this).data('id');
        $('#extendModal').modal('show');
        $('#confirmExtend').data('id', id);
    });

    $('#confirmExtend').click(function() {
        var id = $(this).data('id');
        var days = $('#days').val();
        $.post('/vps-manager/extend-expiration/' + id, { 
            _token: $('meta[name="csrf-token"]').attr('content'),
            days: days
        })
        .done(function() {
            $('#extendModal').modal('hide');
            location.reload();
        })
        .fail(function() {
            alert('Failed to extend expiration. Please try again.');
        });
    });
});
                        $(document).ready(function() {
                            $('#admin_viewer').change(function() {
                                var checked = $(this).is(':checked');
                                var userId = <?= $usr['id'] ?>;
                                $.ajax({
                                    url: 'update_user.php',
                                    type: 'POST',
                                    data: {
                                        userId: userId,
                                        adminView: checked ? 1 : 0
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        location.reload();
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.responseText);
                                    }
                                });
                            });
                        });
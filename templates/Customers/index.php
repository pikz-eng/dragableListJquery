<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Sortable - Default functionality</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/webroot/css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable").sortable({
                connectWith: ".connectedSortable",
                update: function () {
                    var position = $('#sortable').sortable('toArray').toString();
                    var csrfToken = $("input[name='_csrfToken']").val();
                    var data = {customer: position, _csrfToken: csrfToken};

                    $.ajax({
                        type: "POST",
                        url: "/my_app/customers/index",
                        dataType: "json",
                        data: data,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader(
                                'X-CSRF-Token',
                                <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>
                            );
                        },
                        success: function (data) {
                            if (data.response == 'OK') {
                                console.log("Success:" + data.message);
                            } else {
                                console.log("Failed" + data.message);
                            }
                        }
                    });
                }
            })
        });
    </script>
</head>
<body>

<ul id="sortable" class="connectedSortable">
    <?php foreach ($customers as $customer): ?>
        <li class="ui-state-default" id="<?= $customer['id'] ?>"><?php echo $customer['name']; ?></li>
    <?php endforeach; ?>
</ul>
<?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken')]); ?>


</body>


</html>

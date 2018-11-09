
<style>
    table {




    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: left;
    }
    table#t01 tr:nth-child(even) {
        background-color: #eee;
    }
    table#t01 tr:nth-child(odd) {
        background-color: #fff;
    }
    table#t01 th {
        background-color: black;
        color: white;
    }
    .cut-text {
        width : 100%;
        overflow:hidden;
        display:inline-block;
        text-overflow: ellipsis;
        white-space: nowrap;
    }


</style>


<div class="modal-content"  style="margin-top: 2%; margin-left: 20% ">
    <h1>Delete and Edit</h1>
    <br>
    <br>

    {foreach from=$articles item=article}
<form method="post" id="save" action="index.php?page=cms" >
    <table style="width:100%; margin-right: 5%;margin-left: 5%;  table-layout: fixed;" >
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Image link</th>

        </tr>
        <tr>
            <td>{$article[1]}</label><br></td>
            <td>{$article[2]} </label><br></td>
            <td class="cut-text">{$article[3]}<br></td>
            <th><a href="index.php?page=edit&id={$article[0]}"/>EDIT</th>
            <th><a href="index.php?page=delete&id={$article[0]}"/>DELETE</th>

        </tr>

    </table>
</form>


    {/foreach}



    <br>


    {*<div  style="text-align: center; background-color: white; margin-right: 40%; margin-left: 40%;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">*}
        {*{if $current_page gt 1}*}
            {*<a href="index.php?page=cms&pageno={$current_page - 1}" style="text-align: center; " class="newsButt">PREVIOUS</a>*}
        {*{/if}*}

        {*<h3 style="margin-right: 40%"> Current page: {$current_page} </h3>*}

        {*{if $current_page lt $number_of_pages}*}

            {*<a href="index.php?page=cms&pageno={$current_page + 1}" style="text-align: center;"  class="newsButt">NEXT</a>*}
        {*{/if}*}
    {*</div>*}

    {*<br>*}
    {*<br>*}



{*</div>*}
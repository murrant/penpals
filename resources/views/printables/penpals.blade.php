
<h3>Penpals for: {{ $penpal->name }}</h3>

<table width="100%">
    @foreach($addresses->chunk($printColumns) as $row)
        <tr>
            @foreach($row as $address)
                <td style="padding: 30px; font-size: 1.3em">
                    @foreach(explode(PHP_EOL, $address->toString()) as $line)
                        {{ $line }} <br/>
                    @endforeach
                </td>
            @endforeach
        </tr>
    @endforeach
</table>

<script type="text/javascript">
    try {
        this.print();
    }
    catch(e) {
        window.onload = window.print;
    }
</script>

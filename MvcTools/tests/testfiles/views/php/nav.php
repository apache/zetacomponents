<div id='nav'>
<?php
for ( $i = 1; $i <= $this->navMaxPages; $i++ )
{
    if ( $i == $this->navCurrentPage )
    {
        echo " [$i] ";
    }
    else
    {
        echo " <a href='?page=$i'>$i</a> ";
    }
}
?> 
</div>

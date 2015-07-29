
        <a href="[field:typelink/]"
         [field:linktitle runphp='yes']if(@me!=""){@me="title=\"".@me."\"";}[/field:linktitle]>
         [field:kind runphp='yes']
           if(@me==1)
             {
              @me='<s class="ico_new"></s>';
             }
            else if(@me==2)
             {
              @me='<s class="ico_hot"></s>';
             }
            else
             {
              @me='';
             }
         [/field:kind]
       [field:typename/]</a>
      
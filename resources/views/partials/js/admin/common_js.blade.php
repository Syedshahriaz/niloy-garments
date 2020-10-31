<script>

    function getFormattedDate(original_date,format=''){
        const dayNames = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday",
            "Sunday"
        ];
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        original_date = original_date.replace(' ', 'T');
        var formattedDate = new Date(original_date);

        var d = formattedDate.getDate();
        var day = formattedDate.getDay();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        var hours = formattedDate.getHours();
        var minutes = formattedDate.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;

        if(original_date=='' || original_date===null){
            return '';
        }
        if(format==''){
            return (d + '/' + m + '/' + y + ' ' + hours + ':' + minutes +' '+ampm);
        }
        else if(format=='m/d/Y'){
            if(d<10){
                d = '0'+d;
            }
            if(m<10){
                m = '0'+m;
            }
            return m + "/" + d + "/" + y;
        }
        else if(format=='d/m/Y'){
            if(d<10){
                d = '0'+d;
            }
            m = m+1;
            if(m<10){
                m = '0'+m;
            }
            return d + "/" + m + "/" +  y;
        }
        else if(format=='y-m-d'){
            if(d<10){
                d = '0'+d;
            }
            m = m+1;
            if(m<10){
                m = '0'+m;
            }
            return y + "-" + m + "-" + d;
        }
        else if(format=='M d'){
            return monthNames[m-1] + " " + d;
        }
        else if(format=='M-d-y'){
            return monthNames[m-1] + "-" + d + "-" + y;
        }
        else if(format=='l M d, Y h:i a'){
            return (dayNames[day] + ' ' + monthNames[m-1] + ' ' + d +', ' + y + ' ' + hours + ':' + minutes +' '+ampm);
        }
        else{
            return monthNames[m-1] + " " + d + ", " + y;
        }
    }

    $(document).on('change','#day, #month, #year',function(){
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var date = year+'-'+month+'-'+day;

        $('#shipment_date').val(date);
    });

    function isFutureDate(date){
        var CurrentDate = new Date();
        var GivenDate = new Date(date);

        if(GivenDate > CurrentDate){
            return 1;
        }

        return 0;
    }

</script>

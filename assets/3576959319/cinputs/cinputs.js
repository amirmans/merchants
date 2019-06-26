if(typeof CommonInput =="undefined")
{
    function CommonInput(name)
    {
        this.name = name;
        this.init();
    }
    CommonInput.prototype = {
        name:null,
        events:{},
        init:function(){},
        val:function()
        {
            return null;
        },
        on:function(eventName,func)
        {
            this.events[eventName] = func;
        },
        fireEvent(eventName,params)
        {
            if(typeof this.events[eventName]!="undefined")
            {
                this.events[eventName](params);
            }
        },
    };
    
    function RadioList(name)
    {
        CommonInput.call(this,name);
    }
    RadioList.prototype = Object.create(CommonInput.prototype);
    Object.assign(RadioList.prototype,{
        init:function()
        {
            $('input[name='+this.name+']').on('change',function(){
                var params = {
                    value:$('input[name='+this.name+']:checked').val(),
                    text:$('input[name='+this.name+']:checked').next().text(),
                };
                this.fireEvent('change',params);                
            }.bind(this));
        },
        val:function()
        {
            return $('input[name='+this.name+']:checked').val();
        }
    });


    function CheckBoxList(name)
    {
        CommonInput.call(this,name);
    }
    CheckBoxList.prototype = Object.create(CommonInput.prototype);
    Object.assign(CheckBoxList.prototype,{
        init:function()
        {
            $('input[aName='+this.name+']').on('change',function(){
                this.fireEvent('change',{value:this.val()});                
            }.bind(this));
        },
        val:function()
        {
            var value = [];
            $('input[aName='+this.name+']:checked').each(function(){
                value.push($(this).val());
            });
            return value;
        }
    });
}
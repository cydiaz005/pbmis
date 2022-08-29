<span wire:poll.1000ms>{{$percentage}}%
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (el, component) => {
                let done = @this.done;
                console.log("this", @this.done);
                console.log("this", @this.percentage);
                if(done){
                    window.location.reload();
                }
            })
        });
    </script>
</span>

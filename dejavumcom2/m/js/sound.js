/**
 * 사운드 컨트롤
 * @param source    사운드 파일 경로
 * @param volume    기본 볼륨
 * @param loop      반복 실행 여부
 */
function Sound(id,source,volume,loop)
{
    this.id = id;
    this.source = source;
    this.volume = volume;
    this.loop = loop;
    var son;
    var parent;
    this.parent = parent;
    this.son = son;
    this.finish = false;

    this.init = function()
    {
        if(this.finish)return false;
        this.parent = document.createElement('audio');
        this.parent.setAttribute("id", this.id);
        this.son = document.createElement("source");
        this.son.setAttribute("src",this.source);
        this.son.setAttribute("type", "audio/mpeg");
        this.son.setAttribute("hidden","true");
        this.son.setAttribute("volume",this.volume);
        this.son.setAttribute("autostart","true");
        this.parent.setAttribute("loop",this.loop);
        this.parent.appendChild(this.son);

        document.body.appendChild(this.parent);
    }

    this.startMusic = function()
    {
        this.parent.play();
        // if( this.parent.currentTime > 0) 
        // // INVALID_STATE_ERR를 피하기 위한 꼼수 
        // this.parent.currentTime = 0; 
    }
    this.pauseMusic = function()
    {
        this.parent.pause();
    }
    this.stopMusic = function()
    {
      this.parent.stop(); 
    }
}
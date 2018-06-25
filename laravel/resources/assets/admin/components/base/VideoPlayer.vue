<template>
  <video-player  class="video-player-box"
                 ref="videoPlayer"
                 :options="playerOptions"
                 :playsinline="true"
                 customEventName="customstatechangedeventname"
                 @play="onPlayerPlay($event)"
                 @pause="onPlayerPause($event)"
                 @ended="onPlayerEnded($event)"
                 @statechanged="playerStateChanged($event)"
                 @seeked="seekChanged($event)"
                 @ready="playerReadied">
  </video-player>
</template>

<script>
  // Similarly, you can also introduce the plugin resource pack you want to use within the component
  // import 'some-videojs-plugin'
import 'video.js/dist/video-js.css'
import { videoPlayer } from 'vue-video-player'
import 'videojs-offset'
import 'videojs-vjsdownload'
import 'videojs-vjsdownload/dist/videojs-vjsdownload.css'

export default {
  components: {
    videoPlayer
  },
  props: ['video_url', 'sample', 'highTime'],
  data() {
    return {
      playerOptions: {
        // videojs options
        muted: true,
        language: 'en',
        playbackRates: [0.7, 1.0, 1.5, 2.0],
        sources: [{
          type: "video/mp4",
          src: this.video_url
        }],
        poster: "",
      }
    }
  },
  mounted() {
    console.log('this is current player instance object', this.player)
  },
  computed: {
    player() {
      return this.$refs.videoPlayer.player
    }
  },
  watch: {
    highTime: function() {
      if(this.highTime > 0) {
        this.player.currentTime(this.highTime);
        this.highTime = '';
      } else {
        console.log('no highTime');
      }
      console.log(this.highTime);
    }
  },
  methods: {
    // listen event
    onPlayerPlay(player) {
      console.log('player play!', player);
    },
    onPlayerPause(player) {
      console.log(player.currentTime());
      console.log('player pause!');
    },
    // ...player event

    // or listen state event
    playerStateChanged(playerCurrentState) {
      console.log('player current update state', playerCurrentState);
    },

    // player is ready
    playerReadied(player) {
      console.log('the player is readied', player);
      // you can use it to do something...
      // player.[methods]
      if (this.sample) {
        this.player.offset({
          start: 0,
          end: 30,
          restart_beginning: true //Should the video go to the beginning when it ends
        });
      }
    },
    onPlayerEnded(player) {
      console.log('ending!!');
    },
    seekChanged(player) {
      console.log('seeking');
    }
  }
}
</script>
<style lang="scss" scrop>
  .video-js{
    width: 100%;
    height: 400px;
  }
  // .vjs_video_1-dimensions{
  //   width: 60%;
  //   height: 60%;
  // }
</style>

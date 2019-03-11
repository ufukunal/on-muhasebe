/* Todo Widget
 * --------------------
 *  Fetches latest tweets for the user provided
 *  in the plugin options.
 */


var Todo = function Todo(node) {
  var tasks = [];

  // Initialise list from the node
  var lists = node.getElementsByTagName('li');
  for( var i = 0; i < lists.length; i++ ) {
    var item = {
      text: lists[i].innerHTML,
      checked: JSON.parse( JSON.stringify( lists[i].dataset ) ).checked ? true : false
    };
    tasks.push(item);
  }

  // Todo App
  var Todo = {
    data: {
      tasks: [],
    },
    oninit: function(vnode) {
      vnode.state.data.tasks = tasks;
    },
    view: function(vnode) {
      var self = this;
      var ctrl = this.ctrl(vnode);
      return [
        m('div.list-group', [
          vnode.state.data.tasks.map(function(item, index) {
            return [
              m('div', {
                class: 'list-group-item todo-item checkbox checkbox-info ' + ( item.checked ? ' checked' : ''),
              }, [
                m('label', [
                  m('input[type="checkbox"]', {
                    onchange: m.withAttr("value", ctrl.checkTask),
                    value: index,
                    checked: item.checked,
                  }),
                  m('span.label-text', item.text),
                ]),

                m('span.delete-item.material-icons', {
                  onclick: m.withAttr("value", ctrl.deleteTask),
                  value: index,
                }, 'delete'),

                m('span.edit-item.material-icons', {
                  onclick: m.withAttr("value", ctrl.editTask),
                  value: index,
                }, 'edit'),
              ]),
            ];
          }),
          m(this.noTaskMessage, { tasks: vnode.state.data.tasks } ),
        ]),
        m('input[type="text"].form-control', {
          onkeypress: ctrl.addTask,
          placeholder: 'add new task',
        }, 'Add task'),
      ];
    },

    ctrl: function( vnode ) {
      return {

        // Adding task on Enter Press of Input field
        addTask: function(e) {
          if( e.keyCode == 13 ) {
            var val = e.target.value;
            vnode.state.data.tasks.push( { text: val, checked: false } );
            e.target.value = '';
          }
        },

        // Check to task on click
        checkTask: function(index) {
          if( vnode.state.data.tasks[index] !== undefined)
          vnode.state.data.tasks[index].checked = !vnode.state.data.tasks[index].checked;
        },

        // Delete task
        deleteTask: function(index) {
          vnode.state.data.tasks.splice(index, 1);
        },

        // Edit Task by adding a text field in the list
        editTask: function(index) {
          var parentNode = this.parentNode;
          var labelText = parentNode.getElementsByClassName('label-text')[0];
          var text = labelText.innerHTML;
          labelText.style.display = "none";
          parentNode.getElementsByClassName('delete-item')[0].style.display = "none";
          parentNode.getElementsByClassName('edit-item')[0].style.display = "none";

          // View of the Text Field
          var EditField = {
            view: function() {
              var self = this;
              return [
                m('div.edit-field', [
                  m('form.mr-t-0', {
                    onsubmit: function( e ) {
                      var container = parentNode.getElementsByClassName('edit-container-field')[0];
                      var value = container.getElementsByTagName('input')[0].value;
                      vnode.state.data.tasks[index].text = value;
                      labelText.style.display = "block";
                      parentNode.getElementsByClassName('delete-item')[0].style.display = "block";
                      parentNode.getElementsByClassName('edit-item')[0].style.display = "block";
                      container.parentNode.removeChild( container );
                    }
                  }, m('input[type="text"].form-control', {
                    value: text,
                  }),
                    m('button[type="submit"].submit-btn.btn.btn-info', [
                      m('i.material-icons', 'send'),
                    ])
                  ),
                ]),
              ];
            }
          };

          var prevEditField = parentNode.parentNode.getElementsByClassName('edit-container-field');
          if ( prevEditField.length ) {
            var event = document.createEvent('HTMLEvents');
            event.initEvent('submit', true, false);
            prevEditField[0].getElementsByTagName('form')[0].dispatchEvent( event );
          }
          var editContainer = document.createElement('div');
          editContainer.classList.add('edit-container-field');
          parentNode.getElementsByTagName('label')[0].appendChild( editContainer );
          m.mount( editContainer, EditField );
        },
      };
    },
  };

  // View of Message when there is no task in the list
  Todo.noTaskMessage = {
    view: function(vnode) {
      if( vnode.attrs.tasks.length === 0 ) {
        return [
          m('div.list-group-item', [
            m('label', 'no tasks to display'),
          ]),
        ];
      }
      return null;
    }
  };

  return m.mount(node, Todo);
}




/* Twitter Feed Widgets
 * --------------------
 *  Fetches latest tweets for the user provided
 *  in the plugin options.
 */

var TwitterWidget = function TwitterWidget(node, options) {
  var WidgetOptions = options;

  var TweetsList = {
    view: function(vnode) {
      if ( vnode.attrs.tweets !== undefined ) {
        return vnode.attrs.tweets.map( function(tweet, index) {
          var hidden = index !== 0 ? 'hidden' : '';
          return m('div.status', {
            class: 'animated fadeInLeft',
            hidden: hidden,
          },[
            m('p', tweet.text),
          ]);
        });
      }
      return m('p', 'no items to show');
    },
  };

  var TwitterWidget = {
    data: {
      tweets: [],
      user: {
        name: 'John Doe',
        screen_name: 'johndoe',
        profile_image_url: 'assets/demo/users/user-image.png',
      },
    },
    oninit: function(vnode) {
      var ctrl = this.ctrl(vnode);
      ctrl.getQuery();
    },
    view: function(vnode) {
      var ctrl = this.ctrl(vnode);
      return [
        m('div.status-container', [
          m('div.user-info', [
            m('img.user-profile-picture', { src: vnode.state.data.user.profile_image_url, alt: vnode.state.data.user.screen_name + ' profile picture'  }),
            m('div.user-name-group', [
              m('h5.user-name', vnode.state.data.user.name),
              m('h6.user-screen-name.ltr', '@' + vnode.state.data.user.screen_name),
            ]),
            m('i.widget-icon.feather.feather-twitter', null),
          ]),
          m('div.flex-1', null),
          m( TweetsList, { oncreate: ctrl.slideTweets, tweets: vnode.state.data.tweets } ),
        ]),
      ];
    },
    ctrl: function(vnode) {
      return {
        getQuery: function() {
          var queryString = "";
          queryString = m.buildQueryString(JSON.parse(WidgetOptions));
          queryString = '?' + queryString;
          var url = 'assets/vendors/theme-widgets/getTwitterFeed.php' + queryString;
          m.request({
            method: "GET",
            url: url,
            callbackKey: 'none'
          }).then( function(results) {
            if ( results.error === undefined ) {
              vnode.state.data.tweets = JSON.parse( JSON.stringify(results) );
              vnode.state.data.user = vnode.state.data.tweets[0].user;
            }
            else
            console.error( results );
          }).catch( console.error );
        },

        slideTweets: function() {
          var current = 0;
          var statusDoms = vnode.dom.getElementsByClassName('status');
          function showSlide() {
            if ( vnode.state.data.tweets.length === 0 ) return;

            var prev = current - 1;
            if ( prev == -1 ) prev = vnode.state.data.tweets.length - 1;

            var currentStatusNode = statusDoms[current];
            if ( currentStatusNode !== undefined )
            currentStatusNode.hidden = '';

            var prevStatusNode = statusDoms[prev];
            if ( prevStatusNode !== undefined )
            prevStatusNode.hidden = 'hidden';

            if ( current == vnode.state.data.tweets.length - 1 ) current = 0;
            else current++;
          }
          showSlide();
          setInterval(showSlide, 5000);
        },
      };
    },
  };

  var App = {
    view: function(vnode) {
      return m('h4','jfdkas');
    },
  };

  m.mount( node, TwitterWidget );
}




/* Facebook Feed Widget
 * --------------------
 *  Fetches latest tweets for the user provided
 *  in the plugin options.
 */

var FacebookWidget = function FacebookWidget(node, options) {
  var WidgetOptions = options;
  var FacebookList = {
    view: function(vnode) {
      if ( vnode.attrs.statuses !== undefined ) {
        return [
          vnode.attrs.statuses.map(function(status, index) {
            var hidden = ( index !== 0 ) ? 'hidden' : '';
            var story = '';
            if ( status.message !== undefined )
              story = status.message;
            else if ( status.story !== undefined )
              story = status.story;

            story = story.length > 160 ? story.substring(0,160) : story;
            return m('div.status', {
              class: "animated fadeInLeft",
              hidden: hidden,
            },[
              m('p', story),
            ]);
          }),
        ];
      }

      return m('p','no posts to show');
    },
  };

  var FacebookWidget = {
    data: {
      statuses: [],
      user: {
        name: 'John Doe',
        username: 'johndoe',
        picture: {
          data: {
            url: 'assets/demo/users/user-image.png',
          }
        }
      }
    },
    oninit: function(vnode) {
      var ctrl = this.ctrl(vnode);
      ctrl.fetchStatus();
    },
    view: function(vnode) {
      var ctrl = this.ctrl(vnode);
      return [
        m('div.status-container',[
          m('div.user-info',[
            m('img.user-profile-picture', { src: vnode.state.data.user.picture.data.url }),
            m('div.user-name-group', [
              m('h5.user-name', vnode.state.data.user.username),
              m('h6.user-screen-name.ltr', '@' + vnode.state.data.user.username),
            ]),
            m('i.widget-icon.feather.feather-facebook', null),
          ]),
          m('div.flex-1', null),
          m(FacebookList, { oncreate: ctrl.slideStatus, statuses: vnode.state.data.statuses } ),
        ]),
      ];
    },

    ctrl: function(vnode) {
      return {
        fetchStatus: function() {
          var queryString = "";
          queryString = m.buildQueryString(JSON.parse(WidgetOptions));
          queryString = '?' + queryString;
          var url = 'assets/vendors/theme-widgets/getFacebookFeed.php' + queryString;
          m.request({
            method: 'GET',
            url: url,
            callbackKey: 'none'
          }).then(function(results) {
            if ( results.error === undefined ) {
              vnode.state.data.statuses = results[0].data;
              vnode.state.data.user = results[1];
            }
            else {
              results.dom = node;
              console.error( results );
            }
          }).catch(function(err) {
            err.dom = node;
            console.error( err );
          });
        },

        slideStatus: function() {
         var current = 0;
          var statusDoms = vnode.dom.getElementsByClassName('status');
          function showSlide() {
            var prev = current - 1;
            if ( prev == -1 ) prev = vnode.state.data.statuses.length - 1;

            var currentStatusNode = statusDoms[current];
            if ( currentStatusNode !== undefined )
            currentStatusNode.hidden = '';

            var prevStatusNode = statusDoms[prev];
            if ( prevStatusNode !== undefined )
            prevStatusNode.hidden = 'hidden';

            if ( current == vnode.state.data.statuses.length - 1 ) current = 0;
            else current++;
          }
          showSlide();
          setInterval(showSlide, 5000);
        },
      };
    },
  };

  m.mount( node, FacebookWidget);
}

window.Todo = Todo;
window.FacebookWidget = FacebookWidget;
window.TwitterWidget = TwitterWidget;

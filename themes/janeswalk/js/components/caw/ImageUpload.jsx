/* global React CCM_TOOLS_PATH */

// Flux
import { translateTag as t } from 'janeswalk/stores/I18nStore';

export default class ImageUpload extends React.Component {
  constructor(props) {
    super(props);
    Object.assign(this, {
      removeImage: (i) => {
        const thumbnails = this.props.valueLink.value;
        thumbnails.splice(i, 1);
        this.props.valueLink.requestChange(thumbnails);
      },

      handleUpload: (e) => {
        const fd = new FormData();
        const xhr = new XMLHttpRequest();

        if (e.currentTarget.files) {
          // TODO: Update to support uploading multiple files at once
          // TODO: display a spinner w/ the local file as the BG until
          // TODO: Move to flux
          // it's fully uploaded
          // Load one file
          fd.append('Filedata', e.currentTarget.files[0]);

          // Form validation token, generated by concrete5
          fd.append('ccm_token', this.props.valt);

          xhr.open('POST', `${CCM_TOOLS_PATH}/files/importers/quick`);
          xhr.onload = () => {
            try {
              const thumbnails = this.props.valueLink.value;
              const data = JSON.parse(xhr.responseText);
              thumbnails.push(data);
              this.props.valueLink.requestChange(thumbnails);
            } catch (ex) {
              console.log('Error uploading image.');
            }
          };
          xhr.send(fd);
        }
      },
    });
  }

  render() {
    const thumbnails = this.props.valueLink.value;
    // TODO: include an upload callback that loads the uploaded image locally,
    // instead of the one off the server
    // TODO: Implement server-side support for multiple thumbnails, then
    // remove limit here
    return (
      <form className="upload-image">
        <label htmlFor="walkphotos" id="photo-tip">{ t`Upload a photo that best represents your walk. Use the 'Preview Walk' button on the left to see how it will look on your walk page. If you are having trouble uploading, reduce size of the photo.` }</label>
        {thumbnails.map((thumb, i) => {
          // Grab just the name, so local files being uploaded have the same key as the hosted URL
          const filename = `${thumb.url || ''}i`.replace(/^.*[\\\/]/, '');
          const handleRemove = () => this.removeImage(i);

          return (
            <div
              key={filename}
              className="thumbnail"
              style={{ backgroundImage: `url(${thumb.url})` }}
            >
              <a className="remove" onClick={handleRemove}>
                <i className="fa fa-times-circle" />
              </a>
            </div>
            );
        })}
        {(thumbnails.length < 1) ?
        <div className="thumbnail fileupload">
          <input className="ccm-al-upload-single-file" type="file" onChange={this.handleUpload} />
          <i className="fa fa-camera-retro fa-5x" />
          <span className="fileupload-new">{ t`Click to upload an image` }</span>
        </div> : undefined}
      </form>
    );
  }
}

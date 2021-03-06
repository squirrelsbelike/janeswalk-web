/* global React */

// Date formatter
let dtfDate;
let dtfTime;
if (typeof(Intl) === 'object') {
  dtfDate = new Intl.DateTimeFormat(undefined, {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    timeZone: 'UTC',
  });

  dtfTime = new Intl.DateTimeFormat(undefined, {
    hour: 'numeric',
    minute: '2-digit',
    timeZone: 'UTC',
  });
}


export default function ListItem({ walk: { map, url, title }, slot }) {
  let Meeting;
  let startDate;
  let startTime;

  const start = slot[0] * 1000;
  // TODO: safari?
  if (dtfDate) {
    startDate = dtfDate.format(start);
    startTime = dtfTime.format(start);
  }

  /* We show the meeting place title if set, but if not show the description. Some leave the title empty. */
  if (map && map.markers && map.markers.length) {
    Meeting = map.markers[0].title || map.markers[0].description;
  }

  return (
    <tr>
      <td>
        {startDate}
      </td>
      <td>
        {startTime}
      </td>
      <td>
        <a href={url} target="_blank" >
          {title}
        </a>
      </td>
      <td>
        {Meeting}
      </td>
    </tr>
  );
}

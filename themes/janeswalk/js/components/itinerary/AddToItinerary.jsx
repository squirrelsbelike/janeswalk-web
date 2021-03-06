/* global React */

import { dateFormatted } from 'janeswalk/utils/ItineraryUtils';
import { t2 } from 'janeswalk/stores/I18nStore';

const AddToItinerary = ({ schedule, time, walk, onSchedule, onUnschedule }) => {
  const addButtons = [];
  const timeSet = schedule.get(walk) || new Set();

  if (time && time.slots) {
    addButtons.push(...time.slots.map(t => {
      const date = dateFormatted(t[0]);
      const duration = t2('%s Hour', '%s Hours', (t[1] - t[0]) / 3600);
      if (timeSet.has(+t[0])) {
        return (
          <h4>
            {date}, {duration}
            <button className="removeItinerary" onClick={() => onUnschedule(+t[0])} />
          </h4>
        );
      }
      return (
        <h4>
          {date}, {duration}
          <button className="addItinerary" onClick={() => onSchedule(+t[0])} />
        </h4>
      );
    }));
  }
  return (
    <section>
      {addButtons}
    </section>
  );
};

export default AddToItinerary;

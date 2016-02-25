const WalkParking = ({accessibleParking, style}) => {
  if (accessibleParking && accessibleParking.length > 0) {
    return (
      <section className={`walkParking ${style}`}>
        {style === 'walk-page' ? <a name="Parking Availability"></a> : null}
        <a name="Parking Availability"></a>
        <h2>Parking Availability</h2>
        {accessibleParking}
      </section>
    );
  } else {
    return <section/>;
  }
};

WalkParking.propTypes = {
 accessibleParking: React.PropTypes.string.isRequired,
};

export default WalkParking;
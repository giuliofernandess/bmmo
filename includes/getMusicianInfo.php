<?php

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";

$musiciansDAO = new MusiciansDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);

$login = $_SESSION['musician_login'] ? trim($_SESSION['musician_login']) : null;
$musician = $musiciansDAO->findByLogin($login);

$instrumentName = '';
$groupName = '';

if ($musician) {
	foreach ($instrumentsDAO->getAll() as $instrument) {
		if (($instrument->getInstrumentId() ?? 0) === $musician->getInstrument()) {
			$instrumentName = $instrument->getInstrumentName();
			break;
		}
	}

	foreach ($bandGroupsDAO->getAll() as $group) {
		if (($group->getGroupId() ?? 0) === $musician->getBandGroup()) {
			$groupName = $group->getGroupName();
			break;
		}
	}

	$musicianInfo = [
		'musician_id' => $musician->getMusicianId(),
		'musician_login' => $musician->getMusicianLogin(),
		'instrument' => $musician->getInstrument(),
		'band_group' => $musician->getBandGroup(),
		'musician_name' => $musician->getMusicianName(),
		'instrument_name' => $instrumentName,
		'group_name' => $groupName,
		'date_of_birth' => $musician->getDateOfBirth(),
		'musician_contact' => (string) ($musician->getMusicianContact() ?? ''),
		'responsible_name' => (string) ($musician->getResponsibleName() ?? ''),
		'responsible_contact' => (string) ($musician->getResponsibleContact() ?? ''),
		'neighborhood' => $musician->getNeighborhood(),
		'institution' => (string) ($musician->getInstitution() ?? ''),
		'profile_image' => (string) ($musician->getProfileImage() ?? ''),
	];
} else {
	$musicianInfo = null;
}

?>
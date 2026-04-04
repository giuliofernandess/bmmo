<?php

require_once BASE_PATH . "app/DAO/MusiciansDAO.php";
require_once BASE_PATH . "app/DAO/InstrumentsDAO.php";
require_once BASE_PATH . "app/DAO/BandGroupsDAO.php";

$musiciansDAO = new MusiciansDAO($conn);
$instrumentsDAO = new InstrumentsDAO($conn);
$bandGroupsDAO = new BandGroupsDAO($conn);

$login = $_SESSION['musician_login'] ? trim($_SESSION['musician_login']) : null;
$musician = $musiciansDAO->findByLogin($login);

$sanitize = static function ($value): string {
	return htmlspecialchars(trim((string) ($value ?? '')), ENT_QUOTES, 'UTF-8');
};

$musicianId = 0;
$musicianLogin = '';
$instrumentId = 0;
$bandGroupId = 0;
$musicianName = '';
$instrumentName = '';
$groupName = '';
$dateOfBirth = '';
$musicianContact = '';
$responsibleName = '';
$responsibleContact = '';
$neighborhood = '';
$institution = '';
$profileImage = 'default.png';

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

	$musicianId = (int) ($musician->getMusicianId() ?? 0);
	$musicianLogin = $sanitize($musician->getMusicianLogin());
	$instrumentId = (int) ($musician->getInstrument() ?? 0);
	$bandGroupId = (int) ($musician->getBandGroup() ?? 0);
	$musicianName = $sanitize($musician->getMusicianName());
	$instrumentName = $sanitize($instrumentName);
	$groupName = $sanitize($groupName);
	$dateOfBirth = $sanitize($musician->getDateOfBirth());
	$musicianContact = $sanitize($musician->getMusicianContact());
	$responsibleName = $sanitize($musician->getResponsibleName());
	$responsibleContact = $sanitize($musician->getResponsibleContact());
	$neighborhood = $sanitize($musician->getNeighborhood());
	$institution = $sanitize($musician->getInstitution());

	$rawProfileImage = trim((string) ($musician->getProfileImage() ?? ''));
	$profileImage = $rawProfileImage !== '' ? $sanitize(basename($rawProfileImage)) : 'default.png';
}

?>
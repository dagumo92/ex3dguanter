<?php
class Lighting extends Connection {

    public function getAllLamps($zoneFilter = null) {
        $sql = "SELECT lamps.lamp_id, lamps.lamp_name, lamp_on,
                       lamp_models.model_part_number, lamp_models.model_wattage,
                       zones.zone_name
                FROM lamps
                INNER JOIN lamp_models ON lamps.lamp_model = lamp_models.model_id
                INNER JOIN zones ON lamps.lamp_zone = zones.zone_id";

        if ($zoneFilter && $zoneFilter !== 'all') {
            $sql .= " WHERE zones.zone_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$zoneFilter]);
        } else {
            $stmt = $this->pdo->query($sql);
        }

        $lamps = [];
        while ($row = $stmt->fetch()) {
            $lamps[] = new Lamp($row['lamp_id'], $row['lamp_name'], $row['lamp_on'],
                                $row['model_part_number'], $row['model_wattage'], $row['zone_name']);
        }
        return $lamps;
    }

    public function getPowerByZone() {
        $sql = "SELECT zones.zone_name, SUM(lamp_models.model_wattage) as totalPower
                FROM lamps
                INNER JOIN lamp_models ON lamp_model = lamp_models.model_id
                INNER JOIN zones ON lamps.lamp_zone = zones.zone_id
                WHERE lamp_on = 1
                GROUP BY zones.zone_name";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE lamps SET lamp_on = ? WHERE lamp_id = ?");
        $stmt->execute([$status, $id]);
    }

    public function getZones() {
        return $this->pdo->query("SELECT * FROM zones")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function drawZonesOptions($selectedZone) {
        $zones = $this->getZones();

        foreach ($zones as $zone) {
            $selected = ($zone['zone_id'] == $selectedZone) ? 'selected' : '';
            echo "<option value=\"{$zone['zone_id']}\" $selected>{$zone['zone_name']}</option>";
        }
    }
}
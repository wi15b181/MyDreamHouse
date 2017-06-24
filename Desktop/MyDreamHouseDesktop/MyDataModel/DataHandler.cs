using SharedLibrary;
using SharedLibrary.Entities;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MyDataModel
{
    public class DataHandler
    {
        private LocalDbEntities db = new LocalDbEntities();

        public void InsertHauspaket(HauspaketEntity hauspaketEntity)
        {
            hauspaket h = new hauspaket()
            {
                hauspaket_id = hauspaketEntity.HauspaketId,
                benutzer_id = hauspaketEntity.BenutzerId,
                berater_id = hauspaketEntity.BeraterId,
                hersteller_id = hauspaketEntity.HerstellerId,
                bezeichnung = hauspaketEntity.Bezeichnung,
                grundflaeche = hauspaketEntity.Grundflaeche,
                wohnflaeche = hauspaketEntity.Wohnflaeche,
                stockwerke = hauspaketEntity.Stockwerke,
                preis = hauspaketEntity.Preis,
                archived = hauspaketEntity.Archived
            };

            db.hauspaket.Add(h);
            db.SaveChanges();
        }

        public void UpdateHauspaket(HauspaketEntity hauspaketEntity)
        {
            hauspaket result = (from x in db.hauspaket
                                where x.hauspaket_id == hauspaketEntity.HauspaketId
                                select x).SingleOrDefault();

            result.hauspaket_id = hauspaketEntity.HauspaketId;
            result.benutzer_id = hauspaketEntity.BenutzerId;
            result.berater_id = hauspaketEntity.BeraterId;
            result.hersteller_id = hauspaketEntity.HerstellerId;
            result.bezeichnung = hauspaketEntity.Bezeichnung;
            result.grundflaeche = hauspaketEntity.Grundflaeche;
            result.wohnflaeche = hauspaketEntity.Wohnflaeche;
            result.stockwerke = hauspaketEntity.Stockwerke;
            result.preis = hauspaketEntity.Preis;
            result.archived = hauspaketEntity.Archived;

            db.SaveChanges();

        }

        public void DeleteHauspaket(HauspaketEntity hauspaketEntity)
        {
            hauspaket result = (from x in db.hauspaket
                                where x.hauspaket_id == hauspaketEntity.HauspaketId
                                select x).SingleOrDefault();

            db.hauspaket.Remove(result);
            db.SaveChanges();
        }

        public void InsertHauspaketAttribut(HauspaketAttributEntity hauspaketAttributEntity)
        {
            hauspaket_attribut h = new hauspaket_attribut()
            {
                attribut_id = hauspaketAttributEntity.AttributId,
                attribut_typ = hauspaketAttributEntity.AttributTyp,
                attribut_typ_anzeige = hauspaketAttributEntity.AttributTypAnzeige
            };

            db.hauspaket_attribut.Add(h);
            db.SaveChanges();
        }

        public void UpdateHauspaketAttribut(HauspaketAttributEntity hauspaketAttributEntity)
        {
            hauspaket_attribut result = (from x in db.hauspaket_attribut
                                         where x.attribut_id == hauspaketAttributEntity.AttributId
                                         select x).SingleOrDefault();

            result.attribut_id = hauspaketAttributEntity.AttributId;
            result.attribut_typ = hauspaketAttributEntity.AttributTyp;
            result.attribut_typ_anzeige = hauspaketAttributEntity.AttributTypAnzeige;

            db.SaveChanges();

        }

        public void DeleteHauspaketAttribut(HauspaketAttributEntity hauspaketAttributEntity)
        {
            hauspaket_attribut result = (from x in db.hauspaket_attribut
                                         where x.attribut_id == hauspaketAttributEntity.AttributId
                                         select x).SingleOrDefault();

            db.hauspaket_attribut.Remove(result);
            db.SaveChanges();
        }

        public void InsertHauspaketAttributRegel(HauspaketAttributRegelEntity hauspaketAttributRegelEntity)
        {
            hauspaket_attribut_regel h = new hauspaket_attribut_regel()
            {
                regel_id = hauspaketAttributRegelEntity.RegelId,
                regel_attribut_left_id = hauspaketAttributRegelEntity.RegelAttributLeftId,
                regel_attribut_right_id = hauspaketAttributRegelEntity.RegelAttributRightId,
                regel_preis_modifikator = hauspaketAttributRegelEntity.RegelPreisModifikator,
                regel_erlaubt = hauspaketAttributRegelEntity.RegelErlaubt
            };

            db.hauspaket_attribut_regel.Add(h);
            db.SaveChanges();
        }

        public void UpdateHauspaketAttributRegel(HauspaketAttributRegelEntity hauspaketAttributRegelEntity)
        {
            hauspaket_attribut_regel result = (from x in db.hauspaket_attribut_regel
                                               where x.regel_id == hauspaketAttributRegelEntity.RegelId
                                               select x).SingleOrDefault();

            result.regel_id = hauspaketAttributRegelEntity.RegelId;
            result.regel_attribut_left_id = hauspaketAttributRegelEntity.RegelAttributLeftId;
            result.regel_attribut_right_id = hauspaketAttributRegelEntity.RegelAttributRightId;
            result.regel_preis_modifikator = hauspaketAttributRegelEntity.RegelPreisModifikator;
            result.regel_erlaubt = hauspaketAttributRegelEntity.RegelErlaubt;

            db.SaveChanges();

        }

        public void DeleteHauspaketAttributRegel(HauspaketAttributRegelEntity hauspaketAttributRegelEntity)
        {
            hauspaket_attribut_regel result = (from x in db.hauspaket_attribut_regel
                                               where x.regel_id == hauspaketAttributRegelEntity.RegelId
                                               select x).SingleOrDefault();

            db.hauspaket_attribut_regel.Remove(result);
            db.SaveChanges();
        }

        public void InsertHauspaketAttributWert(HauspaketAttributWertEntity hauspaketAttributWertEntity)
        {
            hauspaket_attribut_wert h = new hauspaket_attribut_wert()
            {
                wert_id = hauspaketAttributWertEntity.WertId,
                attribut_id = hauspaketAttributWertEntity.AttributId,
                wert_ordnung = hauspaketAttributWertEntity.WertOrdnung,
                wert_text = hauspaketAttributWertEntity.WertText,
                archived = hauspaketAttributWertEntity.Archived
            };

            db.hauspaket_attribut_wert.Add(h);
            db.SaveChanges();
        }

        public void UpdateHauspaketAttributWert(HauspaketAttributWertEntity hauspaketAttributWertEntity)
        {
            hauspaket_attribut_wert result = (from x in db.hauspaket_attribut_wert
                                              where x.wert_id == hauspaketAttributWertEntity.WertId
                                              select x).SingleOrDefault();

            result.wert_id = hauspaketAttributWertEntity.WertId;
            result.attribut_id = hauspaketAttributWertEntity.AttributId;
            result.wert_ordnung = hauspaketAttributWertEntity.WertOrdnung;
            result.wert_text = hauspaketAttributWertEntity.WertText;
            result.archived = hauspaketAttributWertEntity.Archived;

            db.SaveChanges();

        }

        public void DeleteHauspaketAttributWert(HauspaketAttributWertEntity hauspaketAttributWertEntity)
        {
            hauspaket_attribut_wert result = (from x in db.hauspaket_attribut_wert
                                              where x.wert_id == hauspaketAttributWertEntity.WertId
                                              select x).SingleOrDefault();

            db.hauspaket_attribut_wert.Remove(result);
            db.SaveChanges();
        }

        public void InsertHauspaketAttributZuord(HauspaketAttributZuordEntity hauspaketAttributZuordEntity)
        {
            hauspaket_attribut_zuord h = new hauspaket_attribut_zuord()
            {
                hauspaket_id = hauspaketAttributZuordEntity.HauspaketId,
                wert_id = hauspaketAttributZuordEntity.WertId
            };

            db.hauspaket_attribut_zuord.Add(h);
            db.SaveChanges();
        }

        //Vorsicht, hier sind 2 PK
        public void UpdateHauspaketAttributZuord(HauspaketAttributZuordEntity hauspaketAttributZuordEntity)
        {
            hauspaket_attribut_zuord result = (from x in db.hauspaket_attribut_zuord
                                               where x.wert_id == hauspaketAttributZuordEntity.WertId && x.hauspaket_id == hauspaketAttributZuordEntity.HauspaketId
                                               select x).SingleOrDefault();

            result.hauspaket_id = hauspaketAttributZuordEntity.HauspaketId;
            result.wert_id = hauspaketAttributZuordEntity.WertId;

            db.SaveChanges();

        }

        //Vorsicht, hier sind 2 PK
        public void DeleteHauspaketAttributZuord(HauspaketAttributZuordEntity hauspaketAttributZuordEntity)
        {
            hauspaket_attribut_zuord result = (from x in db.hauspaket_attribut_zuord
                                               where x.wert_id == hauspaketAttributZuordEntity.WertId && x.hauspaket_id == hauspaketAttributZuordEntity.HauspaketId
                                               select x).SingleOrDefault();

            db.hauspaket_attribut_zuord.Remove(result);
            db.SaveChanges();
        }

        public void InsertAttachements(AttachmentsEntity attachementsEntity)
        {
            attachements h = new attachements()
            {
                attachement_id = attachementsEntity.AttachementId,
                bezeichnung = attachementsEntity.Bezeichnung,
                filename = attachementsEntity.Filename,
                hauspaket_id = attachementsEntity.HauspaketId,
                mimetype = attachementsEntity.Mimetype,
                size = attachementsEntity.Size
            };

            db.attachements.Add(h);
            db.SaveChanges();
        }


        public void UpdateAttachements(AttachmentsEntity attachementsEntity)
        {
            attachements result = (from x in db.attachements
                                   where x.attachement_id == attachementsEntity.AttachementId
                                   select x).SingleOrDefault();

            result.attachement_id = attachementsEntity.AttachementId;
            result.bezeichnung = attachementsEntity.Bezeichnung;
            result.filename = attachementsEntity.Filename;
            result.hauspaket_id = attachementsEntity.HauspaketId;
            result.mimetype = attachementsEntity.Mimetype;
            result.size = attachementsEntity.Size;

            db.SaveChanges();

        }


        public void DeleteAttachements(AttachmentsEntity attachementsEntity)
        {
            attachements result = (from x in db.attachements
                                   where x.attachement_id == attachementsEntity.AttachementId
                                   select x).SingleOrDefault();

            db.attachements.Remove(result);
            db.SaveChanges();
        }


        public void InsertBerater(BeraterEntity beraterEntity)
        {
            berater b = new berater()
            {
                benutzer_id = beraterEntity.BenutzerId,
                berater_id = beraterEntity.BeraterId,
                bild = beraterEntity.Bild,
                hersteller_id = beraterEntity.HerstellerId
            };

            db.berater.Add(b);
            db.SaveChanges();
        }


        public void UpdateBerater(BeraterEntity beraterEntity)
        {
            berater result = (from x in db.berater
                              where x.berater_id == beraterEntity.BeraterId
                              select x).SingleOrDefault();

            result.benutzer_id = beraterEntity.BenutzerId;
            result.berater_id = beraterEntity.BeraterId;
            result.bild = beraterEntity.Bild;
            result.hersteller_id = beraterEntity.HerstellerId;
            db.SaveChanges();

        }

        public void DeleteBerater(BeraterEntity beraterEntity)
        {
            berater result = (from x in db.berater
                              where x.berater_id == beraterEntity.BeraterId
                              select x).SingleOrDefault();

            db.berater.Remove(result);
            db.SaveChanges();
        }

        public void InsertHersteller(HerstellerEntity herstellerEntity)
        {
            hersteller h = new hersteller()
            {
                hersteller_id = Convert.ToInt32(herstellerEntity.HerstellerId),
                name = herstellerEntity.Name
            };

            db.hersteller.Add(h);
            db.SaveChanges();
        }

        public void UpdateHersteller(HerstellerEntity herstellerEntity)
        {
            hersteller result = (from x in db.hersteller
                                 where x.hersteller_id == herstellerEntity.HerstellerId
                                 select x).SingleOrDefault();

            result.hersteller_id = Convert.ToInt32(herstellerEntity.HerstellerId);
            result.name = herstellerEntity.Name;
            db.SaveChanges();

        }

        public void DeleteHersteller(HerstellerEntity herstellerEntity)
        {
            hersteller result = (from x in db.hersteller
                                 where x.hersteller_id == herstellerEntity.HerstellerId
                                 select x).SingleOrDefault();

            db.hersteller.Remove(result);
            db.SaveChanges();
        }

        public void InsertSyncJn(SyncJnEntity syncJnEntity)
        {
            sync_jn s = new sync_jn()
            {
                jn_id = syncJnEntity.JnId,
                jn_pk = syncJnEntity.JnPk,
                jn_operation = syncJnEntity.JnOperation,
                jn_synced = syncJnEntity.Synced,
                jn_table = syncJnEntity.JnTable,
                jn_timestampe = syncJnEntity.JnTimestamp,
                jn_changeset_json = syncJnEntity.JnChangesetJson
            };

            db.sync_jn.Add(s);
            db.SaveChanges();
        }

        public void ClearHauspaketAttributZuord()
        {
            var result = (from x in db.hauspaket_attribut_zuord
                          select x).ToList();

            db.hauspaket_attribut_zuord.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearAttachements()
        {
            var result = (from x in db.attachements
                          select x).ToList();

            db.attachements.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearHauspaket()
        {
            var result = (from x in db.hauspaket
                          select x).ToList();

            db.hauspaket.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearBerater()
        {
            var result = (from x in db.berater
                          select x).ToList();

            db.berater.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearHersteller()
        {
            var result = (from x in db.hersteller
                          select x).ToList();

            db.hersteller.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearHauspaketAttributRegel()
        {
            var result = (from x in db.hauspaket_attribut_regel
                          select x).ToList();

            db.hauspaket_attribut_regel.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearHauspaketAttributWert()
        {
            var result = (from x in db.hauspaket_attribut_wert
                          select x).ToList();

            db.hauspaket_attribut_wert.RemoveRange(result);
            db.SaveChanges();
        }
        public void ClearHauspaketAttribut()
        {
            var result = (from x in db.hauspaket_attribut
                          select x).ToList();

            db.hauspaket_attribut.RemoveRange(result);
            db.SaveChanges();
        }
    }
}
